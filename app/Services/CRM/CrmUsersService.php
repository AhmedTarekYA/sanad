<?php

namespace App\Services\CRM;

use App\Models\CRM\CrmUser;
use App\Services\MainService;

class CrmUsersService extends MainService
{
    public function __construct(CrmUser $model)
    {
        $this->model = $model;
        $this->fileFolder = 'crm/users/';
        $this->files = ['image'];
    }

    public function listUsers()
    {
        return $this->model->query()->latest()->get();
    }

    public function storeUser(array $data): CrmUser
    {
        $data = $this->normalize($data);

        return $this->model->create($data);
    }

    public function updateUser(int $id, array $data): CrmUser
    {
        $user = $this->find($id);
        abort_if($user === null, 404);

        $data = $this->normalize($data);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return $user->refresh();
    }

    /** @param array<string, mixed> $data */
    protected function normalize(array $data): array
    {
        $isActive = (bool) ($data['is_active'] ?? false);
        $permissions = isset($data['permissions']) && is_array($data['permissions'])
            ? array_values(array_filter($data['permissions']))
            : null;

        $data = $this->clearRequest($data);
        $data['is_active'] = $isActive;
        $data['permissions'] = $permissions;

        return $data;
    }
}
