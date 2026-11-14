<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappChatTag;
use App\Models\CRM\WhatsappContactTag;
use App\Services\MainService;
use Illuminate\Database\Eloquent\Collection;

class WhatsappLabelService extends MainService
{
    public function __construct(
        protected WhatsappContactTag $contactTag,
        protected WhatsappChatTag $chatTag,
    ) {
        $this->model = $contactTag;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function contactTagsForUser(CrmUser $user): Collection
    {
        return $this->contactTag->query()
            ->where('crm_user_id', $user->id)
            ->withCount('contacts')
            ->orderBy('name')
            ->get();
    }

    public function chatTagsForUser(CrmUser $user): Collection
    {
        return $this->chatTag->query()
            ->where('crm_user_id', $user->id)
            ->withCount('conversations')
            ->orderBy('name')
            ->get();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function storeForUser(CrmUser $user, string $scope, array $data): WhatsappContactTag|WhatsappChatTag
    {
        return $this->modelForScope($scope)->query()->create([
            'crm_user_id' => $user->id,
            'name' => $this->normalizeString($data['name'] ?? null),
            'color' => $this->normalizeString($data['color'] ?? null),
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateForUser(CrmUser $user, string $scope, int $id, array $data): WhatsappContactTag|WhatsappChatTag
    {
        $tag = $this->findForUser($user, $scope, $id);

        abort_if($tag === null, 404);

        $tag->fill([
            'name' => $this->normalizeString($data['name'] ?? null),
            'color' => $this->normalizeString($data['color'] ?? null),
        ]);
        $tag->save();

        return $tag;
    }

    public function deleteForUser(CrmUser $user, string $scope, int $id): bool
    {
        $tag = $this->findForUser($user, $scope, $id);

        if ($tag === null) {
            return false;
        }

        return (bool) $tag->delete();
    }

    public function findForUser(CrmUser $user, string $scope, int $id): WhatsappContactTag|WhatsappChatTag|null
    {
        return $this->modelForScope($scope)->query()
            ->where('crm_user_id', $user->id)
            ->find($id);
    }

    protected function modelForScope(string $scope): WhatsappContactTag|WhatsappChatTag
    {
        return $scope === 'chat' ? $this->chatTag : $this->contactTag;
    }

    protected function normalizeString(mixed $value): ?string
    {
        $normalized = trim((string) $value);

        return $normalized === '' ? null : $normalized;
    }
}
