<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappQuickReply;
use App\Services\MainService;
use Illuminate\Database\Eloquent\Collection;

class WhatsappQuickReplyService extends MainService
{
    public function __construct(WhatsappQuickReply $model)
    {
        $this->model = $model;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function allForUser(CrmUser $user): Collection
    {
        return $this->model->query()
            ->where('crm_user_id', $user->id)
            ->orderByDesc('id')
            ->get();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function storeForUser(CrmUser $user, array $data): WhatsappQuickReply
    {
        return $this->model->query()->create([
            'crm_user_id' => $user->id,
            'title' => $this->normalizeString($data['title'] ?? null),
            'shortcut' => $this->normalizeString($data['shortcut'] ?? null),
            'body' => $this->normalizeString($data['body'] ?? null),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateForUser(CrmUser $user, int $id, array $data): WhatsappQuickReply
    {
        $item = $this->findForUser($user, $id);

        abort_if($item === null, 404);

        $item->fill([
            'title' => $this->normalizeString($data['title'] ?? null),
            'shortcut' => $this->normalizeString($data['shortcut'] ?? null),
            'body' => $this->normalizeString($data['body'] ?? null),
        ]);

        if (array_key_exists('is_active', $data)) {
            $item->is_active = (bool) $data['is_active'];
        }

        $item->save();

        return $item;
    }

    public function deleteForUser(CrmUser $user, int $id): bool
    {
        $item = $this->findForUser($user, $id);

        if ($item === null) {
            return false;
        }

        return (bool) $item->delete();
    }

    public function findForUser(CrmUser $user, int $id): ?WhatsappQuickReply
    {
        return $this->model->query()
            ->where('crm_user_id', $user->id)
            ->find($id);
    }

    protected function normalizeString(mixed $value): ?string
    {
        $normalized = trim((string) $value);

        return $normalized === '' ? null : $normalized;
    }
}
