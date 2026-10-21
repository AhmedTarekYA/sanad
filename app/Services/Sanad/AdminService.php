<?php

namespace App\Services\Sanad;

use App\Enums\AdminTypeisEnum;
use App\Models\Sanad\Admin;
use App\Services\MainService;
use Illuminate\Support\Facades\Auth;

class AdminService extends MainService
{
    public function __construct(Admin $model, private RoleService $roleService)
    {
        $this->model = $model;
        $this->fileFolder = 'images/admin/';
        $this->files = ['image'];
    }

    public function getAuthUser()
    {
        $user = Auth::guard('admin')->user();

        return $user;
    }

    public function storeAdmin($data)
    {
        $data['admin_type'] = AdminTypeisEnum::GlobalManger->value;
        $admin = $this->store($data);
        $admin->syncRoles([$data['role_id']]);

        return $admin;
    }

    public function updateAdmin($id, $data)
    {
        $admin = $this->model->find($id);
        $roleId = $data['role_id'];
        $data = $this->clearRequest($data);
        $admin->update($data);
        $role = $this->roleService->find($roleId);
        $admin->syncRoles([$role->id]);

        return $admin;
    }

    public function getRoles()
    {
        return $this->roleService->get();
    }
}
