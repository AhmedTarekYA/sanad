<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Services\MainService;

class CrmUserService extends MainService
{
    public function __construct(CrmUser $model)
    {
        $this->model = $model;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function getDataTable()
    {
        return $this->model->query()->latest();
    }

    public function storeCrmUser(array $data): CrmUser
    {
        $isActive = (bool) ($data['is_active'] ?? false);
        $data = $this->clearRequest($data);
        $data['is_active'] = $isActive;

        return $this->model->create($data);
    }

    public function updateCrmUser(int $id, array $data): void
    {
        $isActive = (bool) ($data['is_active'] ?? false);
        $crmUser = $this->find($id);
        $data = $this->clearRequest($data);
        $data['is_active'] = $isActive;

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $crmUser->update($data);
    }
}
