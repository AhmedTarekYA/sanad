<?php

namespace App\Models;

use Laratrust\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    protected $table = 'permissions';
    protected $fillable = [
        'name', 'display_name', 'description', 'description_ar', 'created_at', 'updated_at'
    ];
}
