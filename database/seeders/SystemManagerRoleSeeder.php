<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class SystemManagerRoleSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::updateOrCreate(
            ['name' => 'system_manager'],
            ['display_name' => 'مدير النظام', 'description' => 'System Manager with full access']
        );

        $allPermissions = Permission::pluck('id')->toArray();
        $role->permissions()->syncWithoutDetaching($allPermissions);

        $this->command->info('System Manager role created/updated with all permissions.');
    }
}
