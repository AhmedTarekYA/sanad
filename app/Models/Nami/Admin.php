<?php

namespace App\Models\Nami;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements LaratrustUser
{
    use HasRolesAndPermissions;
    use HasFactory;

    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'admin_type',
    ];


    public function assignRole($role)
    {
        return $this->roles()->sync($role);
    }

    public function assignPermissions($role)
    {
        return $this->permissions()->sync($role);
    }

}
