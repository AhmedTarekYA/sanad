<?php

namespace App\Services\Nami;

use App\Services\MainService;
use App\Models\Role;

class RoleService extends MainService
{
    public function __construct(Role $model, private PermissionService $permissionService)
    {
        $this->model = $model;
    }

    public function getPermissions()
    {
        return $this->permissionService->get();
    }

    public function getRolePermissions($id)
    {
        return \DB::table("permission_role")->where("permission_role.role_id", $id)
        ->pluck('permission_role.permission_id', 'permission_role.permission_id')
        ->all();
    }

    public function storeRole($data)
    {
        $role = $this->store($data);
        $permissions = $this->permissionService->getWhereIn('id', $data['permission'] ?? []);
        $role->syncPermissions($permissions);
        return $role;
    }

    public function updateRole($id,$data)
    {
        $role = $this->find($id);
        $role->update($data);
        $permissions = $this->permissionService->getWhereIn('id', $data['permission'] ?? []);
        $role->syncPermissions($permissions);
        return $role;
    }
}
