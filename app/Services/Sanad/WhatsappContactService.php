<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappContact;
use App\Models\CRM\WhatsappContactTag;
use App\Models\CRM\WhatsappConversation;
use App\Models\CRM\WhatsappMessage;
use App\Services\MainService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class WhatsappContactService extends MainService
{
    public function __construct(
        protected WhatsappContact $contact,
        protected WhatsappContactTag $tag,
        protected WhatsappMessage $message,
    ) {
        $this->model = $contact;
        $this->fileFolder = null;
        $this->files = [];
    }

    /**
     * @param  array<string, mixed>  $filters
     */
    public function listForUser(CrmUser $user, array $filters = []): Paginator
    {
        $limit = (int) ($filters['limit'] ?? 25);
        $limit = max(1, min($limit, 200));

        $query = $this->contact->query()
            ->where('crm_user_id', $user->id)
            ->with(['tags:id,name,color']);

        $search = trim((string) ($filters['search'] ?? ''));

        if ($search !== '') {
            $digits = preg_replace('/\D+/', '', $search) ?? '';
            $query->where(function ($query) use ($search, $digits): void {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('wa_id', 'like', '%'.($digits !== '' ? $digits : $search).'%');
            });
        }

        $tagIds = $this->normalizeIds($filters['tag_ids'] ?? []);

        if ($tagIds !== []) {
            $ownedTagIds = $this->tag->query()
                ->where('crm_user_id', $user->id)
                ->whereIn('id', $tagIds)
                ->pluck('id')
                ->all();

            if ($ownedTagIds === []) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereHas('tags', function ($query) use ($ownedTagIds): void {
                    $query->whereIn('whatsapp_contact_tags.id', $ownedTagIds);
                });
            }
        }

        return $query
            ->orderByDesc('last_activity')
            ->orderBy('wa_id')
            ->simplePaginate($limit)
            ->appends($filters);
    }

    public function findForUser(CrmUser $user, int $id): ?WhatsappContact
    {
        return $this->contact->query()
            ->where('crm_user_id', $user->id)
            ->with(['tags:id,name,color'])
            ->find($id);
    }

    /**
     * @return array<string, mixed>
     */
    public function detailsForUser(CrmUser $user, int $id): array
    {
        $contact = $this->findForUser($user, $id);

        abort_if($contact === null, 404);

        $messages = $this->message->query()
            ->where('crm_user_id', $user->id)
            ->where(function ($query) use ($contact): void {
                $query->where('from_wa_id', $contact->wa_id)
                    ->orWhere('to_wa_id', $contact->wa_id);
            });

        $totalMessages = (clone $messages)->count();

        $history = (clone $messages)
            ->orderByDesc('id')
            ->limit(20)
            ->get(['id', 'wamid', 'direction', 'from_wa_id', 'to_wa_id', 'type', 'body', 'wa_timestamp', 'created_at']);

        $totalConversations = WhatsappConversation::query()
            ->where('crm_user_id', $user->id)
            ->where('wa_id', $contact->wa_id)
            ->count();

        return [
            'contact' => $contact,
            'stats' => [
                'last_activity' => $contact->last_activity,
                'total_conversations' => $totalConversations,
                'total_messages' => $totalMessages,
                'registered_at' => $contact->registered_at ?? $contact->created_at,
            ],
            'conversation_history' => $history,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function storeForUser(CrmUser $user, array $data): WhatsappContact
    {
        $contact = $this->contact->query()->firstOrCreate(
            [
                'crm_user_id' => $user->id,
                'wa_id' => $this->normalizeWaId((string) ($data['wa_id'] ?? '')),
            ],
            [
                'registered_at' => now(),
            ]
        );

        $contact->fill($this->contactPayload($data));

        if ($contact->registered_at === null) {
            $contact->registered_at = now();
        }

        $contact->save();

        if (array_key_exists('tag_ids', $data)) {
            $this->syncTags($user, $contact, $data['tag_ids'] ?? []);
        }

        return $contact->load(['tags:id,name,color']);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateForUser(CrmUser $user, int $id, array $data): WhatsappContact
    {
        $contact = $this->findForUser($user, $id);

        abort_if($contact === null, 404);

        $contact->fill($this->contactPayload($data));
        $contact->save();

        if (array_key_exists('tag_ids', $data)) {
            $this->syncTags($user, $contact, $data['tag_ids'] ?? []);
        }

        return $contact->load(['tags:id,name,color']);
    }

    public function deleteForUser(CrmUser $user, int $id): bool
    {
        $contact = $this->findForUser($user, $id);

        if ($contact === null) {
            return false;
        }

        $contact->tags()->detach();

        return (bool) $contact->delete();
    }

    /**
     * @param  array<int, mixed>  $tagIds
     */
    public function syncTags(CrmUser $user, WhatsappContact $contact, array $tagIds): WhatsappContact
    {
        $owned = $this->tag->query()
            ->where('crm_user_id', $user->id)
            ->whereIn('id', $this->normalizeIds($tagIds))
            ->pluck('id')
            ->all();

        $contact->tags()->sync($owned);

        return $contact->load(['tags:id,name,color']);
    }

    /**
     * @return array<string, int|array<int, array<string, mixed>>>
     */
    public function importForUser(CrmUser $user, string $path): array
    {
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return ['created' => 0, 'updated' => 0, 'failed' => 0, 'errors' => []];
        }

        $header = fgetcsv($handle);
        $map = [];

        foreach (($header ?: []) as $index => $column) {
            $map[strtolower(trim((string) $column))] = $index;
        }

        $created = 0;
        $updated = 0;
        $failed = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            $waId = $this->normalizeWaId((string) $this->csvGet($row, $map, ['wa_id', 'waid', 'phone', 'number']));

            if ($waId === '') {
                $failed++;
                $errors[] = ['row' => $rowNumber, 'error' => 'Missing wa_id'];

                continue;
            }

            $contact = $this->contact->query()->firstOrNew([
                'crm_user_id' => $user->id,
                'wa_id' => $waId,
            ]);
            $isNew = ! $contact->exists;

            if ($isNew) {
                $contact->registered_at = now();
            }

            $name = $this->csvGet($row, $map, ['name']);
            $email = $this->csvGet($row, $map, ['email']);
            $source = $this->csvGet($row, $map, ['source']);
            $note = $this->csvGet($row, $map, ['note', 'notes']);

            if ($name !== null && trim($name) !== '') {
                $contact->name = trim($name);
            }
            if ($email !== null && trim($email) !== '') {
                $contact->email = trim($email);
            }
            if ($source !== null && trim($source) !== '') {
                $contact->source = trim($source);
            }
            if ($note !== null && trim($note) !== '') {
                $contact->note = trim($note);
            }

            $customFields = $this->csvGet($row, $map, ['custom_fields', 'customfields']);
            if ($customFields !== null && trim($customFields) !== '') {
                $decoded = json_decode($customFields, true);
                if (is_array($decoded)) {
                    $contact->custom_fields = $decoded;
                }
            }

            $contact->save();

            $tagsRaw = $this->csvGet($row, $map, ['tags', 'labels']);
            if ($tagsRaw !== null && trim($tagsRaw) !== '') {
                $tagIds = [];
                foreach (explode(',', $tagsRaw) as $tagName) {
                    $tagName = trim($tagName);
                    if ($tagName === '') {
                        continue;
                    }
                    $tagIds[] = $this->firstOrCreateTag($user, $tagName)->id;
                }
                if ($tagIds !== []) {
                    $contact->tags()->syncWithoutDetaching($tagIds);
                }
            }

            if ($isNew) {
                $created++;
            } else {
                $updated++;
            }
        }

        fclose($handle);

        return [
            'created' => $created,
            'updated' => $updated,
            'failed' => $failed,
            'errors' => $errors,
        ];
    }

    public function contactTagsForUser(CrmUser $user): Collection
    {
        return $this->tag->query()
            ->where('crm_user_id', $user->id)
            ->withCount('contacts')
            ->orderBy('name')
            ->get();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function storeTagForUser(CrmUser $user, array $data): WhatsappContactTag
    {
        return $this->tag->query()->create([
            'crm_user_id' => $user->id,
            'name' => trim((string) ($data['name'] ?? '')),
            'color' => $this->nullableString($data['color'] ?? null),
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateTagForUser(CrmUser $user, int $id, array $data): WhatsappContactTag
    {
        $tag = $this->findTagForUser($user, $id);

        abort_if($tag === null, 404);

        $tag->fill([
            'name' => trim((string) ($data['name'] ?? $tag->name)),
            'color' => $this->nullableString($data['color'] ?? null),
        ]);
        $tag->save();

        return $tag;
    }

    public function deleteTagForUser(CrmUser $user, int $id): bool
    {
        $tag = $this->findTagForUser($user, $id);

        if ($tag === null) {
            return false;
        }

        $tag->contacts()->detach();

        return (bool) $tag->delete();
    }

    public function findTagForUser(CrmUser $user, int $id): ?WhatsappContactTag
    {
        return $this->tag->query()
            ->where('crm_user_id', $user->id)
            ->find($id);
    }

    protected function firstOrCreateTag(CrmUser $user, string $name): WhatsappContactTag
    {
        return $this->tag->query()->firstOrCreate([
            'crm_user_id' => $user->id,
            'name' => $name,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function contactPayload(array $data): array
    {
        return [
            'name' => $this->nullableString($data['name'] ?? null),
            'profile_pic' => $this->nullableString($data['profile_pic'] ?? null),
            'email' => $this->nullableString($data['email'] ?? null),
            'source' => $this->nullableString($data['source'] ?? null),
            'note' => $this->nullableString($data['note'] ?? null),
            'custom_fields' => $data['custom_fields'] ?? null,
        ];
    }

    /**
     * @param  array<int, mixed>|string  $values
     * @return array<int, int>
     */
    protected function normalizeIds(array|string $values): array
    {
        if (is_string($values)) {
            $values = explode(',', $values);
        }

        return array_values(array_filter(array_map('intval', $values)));
    }

    protected function normalizeWaId(string $value): string
    {
        return preg_replace('/\D+/', '', trim($value)) ?? '';
    }

    /**
     * @param  array<int, string|null>  $row
     * @param  array<string, int>  $map
     * @param  array<int, string>  $keys
     */
    protected function csvGet(array $row, array $map, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (! array_key_exists($key, $map)) {
                continue;
            }

            $value = $row[$map[$key]] ?? null;

            return $value === null ? null : (string) $value;
        }

        return null;
    }

    protected function nullableString(mixed $value): ?string
    {
        $normalized = trim((string) $value);

        return $normalized === '' ? null : $normalized;
    }
}
