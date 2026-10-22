<?php

namespace Database\Seeders;

use App\Enums\AdminTypeisEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Sanad\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaratrustSeeder extends Seeder
{
    private array $roleDisplayNames = [
        'system_manager' => 'مدير النظام',
    ];

    /** @var array<string, array<string, string>> */
    private array $permissionDisplayNames = [
        'admins' => [
            'create' => 'إضافة مشرف',
            'read' => 'عرض المشرفين',
            'update' => 'تعديل مشرف',
            'delete' => 'حذف مشرف',
        ],
        'roles' => [
            'create' => 'إضافة دور',
            'read' => 'عرض الأدوار',
            'update' => 'تعديل دور',
            'delete' => 'حذف دور',
        ],
        'settings' => [
            'create' => 'إضافة إعداد',
            'read' => 'عرض الإعدادات',
            'update' => 'تعديل إعداد',
            'delete' => 'حذف إعداد',
        ],
        'profile' => [
            'read' => 'عرض اللف الشخصي',
            'update' => 'تعديل اللف الشخصي',
        ],
        'change-password' => [
            'read' => 'عرض تغيير كلمة المرور',
            'update' => 'تغيير كلمة المرور',
        ],
        'blogs' => [
            'create' => 'إضافة مقال',
            'read' => 'عرض المقالات',
            'update' => 'تعديل مقال',
            'delete' => 'حذف مقال',
        ],
    ];

    public function run(): void
    {
        $this->truncateLaratrustTables();

        $config = Config::get('laratrust_seeder.roles_structure');

        if ($config === null) {
            $this->command->error('The configuration has not been published. Did you run `php artisan vendor:publish --tag="laratrust-seeder"`?');

            return;
        }

        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $roleName => $modules) {
            $role = Role::updateOrCreate(
                ['name' => $roleName],
                ['display_name' => $this->roleDisplayNames[$roleName] ?? ucfirst($roleName)]
            );

            $permissions = [];

            $this->command->info('Processing Role: '.strtoupper($roleName));

            foreach ($modules as $module => $list_per) {
                $permissionsArray = is_array($list_per) ? $list_per : explode(',', $list_per);

                foreach ($permissionsArray as $perm) {
                    $permissionValue = $mapPermission->get(trim($perm));

                    $displayName = $this->permissionDisplayNames[$module][$permissionValue]
                        ?? ucfirst($permissionValue).' '.ucfirst($module);

                    $permission = Permission::updateOrCreate(
                        ['name' => $module.'-'.$permissionValue],
                        [
                            'display_name' => $displayName,
                            'description' => $displayName,
                        ]
                    );

                    $permissions[] = $permission->id;
                }
            }

            if (! empty($permissions)) {
                $role->permissions()->syncWithoutDetaching($permissions);
            }
        }

        // Give all permissions to admin@admin.com and all Developer admins
        $allPermissions = Permission::pluck('id')->toArray();

        $superAdmins = Admin::where('email', 'admin@admin.com')
            ->orWhere('admin_type', AdminTypeisEnum::Developer->value)
            ->get();

        foreach ($superAdmins as $admin) {
            $admin->permissions()->syncWithoutDetaching($allPermissions);
            $this->command->info('Permissions synced for: '.$admin->email);
        }
    }

    public function truncateLaratrustTables(): void
    {
        $this->command->info('Removing superadministrator role if exists…');
        Schema::disableForeignKeyConstraints();

        // Remove the old superadministrator role completely
        $oldRole = Role::where('name', 'superadministrator')->first();
        if ($oldRole) {
            DB::table('permission_role')->where('role_id', $oldRole->id)->delete();
            DB::table('role_user')->where('role_id', $oldRole->id)->delete();
            $oldRole->delete();
            $this->command->info('superadministrator role removed.');
        }

        if (Config::get('laratrust_seeder.truncate_tables')) {
            DB::table('roles')->truncate();
            DB::table('permission_role')->truncate();
            DB::table('role_user')->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }
}
