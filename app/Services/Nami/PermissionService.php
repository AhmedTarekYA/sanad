<?php

namespace App\Services\Nami;

use App\Services\MainService;
use App\Models\Permission;

class PermissionService extends MainService
{
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
}
