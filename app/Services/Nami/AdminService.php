<?php

namespace App\Services\Nami;
use App\Enums\AdminTypeisEnum;
use App\Models\Nami\Admin;
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
        $data["admin_type"] = AdminTypeisEnum::GlobalManger->value ;
        $admin = $this->store($data);
        $admin->syncRoles([$data['role_id']]);
        return $admin;
    }

    public function updateAdmin($id, $data)
    {
        $admin = $this->model->find($id);
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $admin->update($data);
        $role = $this->roleService->find($data['role_id']);
        $admin->syncRoles([$role->id]);
        return $admin;
    }

    public function getRoles()
    {
        return $this->roleService->get();
    }

}
