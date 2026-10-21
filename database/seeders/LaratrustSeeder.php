<?php

namespace Database\Seeders;

use App\Enums\AdminTypeisEnum;
use App\Models\Nami\Admin;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // لا تحذف الصلاحيات المعطاة للمستخدمين
        $this->truncateLaratrustTables(false);

        $config = Config::get('laratrust_seeder.roles_structure');

        if ($config === null) {
            $this->command->error("The configuration has not been published. Did you run `php artisan vendor:publish --tag=\"laratrust-seeder\"`?");
            $this->command->line('');
            return false;
        }

        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $roleName => $modules) {

            // جلب الدور إذا كان موجودًا، وإلا يتم إنشاؤه
            $role = \App\Models\Role::firstOrCreate([
                'name' => $roleName,
            ]);

            $permissions = [];

            $this->command->info('Processing Role: ' . strtoupper($roleName));

            // قراءة الصلاحيات المرتبطة بالدور
            foreach ($modules as $module => $list_per) {

                // التأكد من أن $list_per عبارة عن مصفوفة، وإذا لم تكن مصفوفة نحولها باستخدام explode
                $permissionsArray = is_array($list_per) ? $list_per : explode(',', $list_per);

                foreach ($permissionsArray as $perm) {
                    $permissionValue = $mapPermission->get(trim($perm));

                    // التحقق مما إذا كانت الصلاحية موجودة قبل إنشائها
                    $permission = \App\Models\Permission::firstOrCreate([
                        'name' => $module . '-' . $permissionValue,
                    ], [
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ]);

                    $permissions[] = $permission->id;
                }
            }

            // إضافة الصلاحيات الجديدة فقط دون حذف القديمة
            if (!empty($permissions)) {
                $role->permissions()->syncWithoutDetaching($permissions);
            }
        }

        // التأكد من أن الأدمن الرئيسي لديه جميع الصلاحيات
        $adminUser = Admin::where('id', 1)->orWhere('admin_type', AdminTypeisEnum::Developer->value)->get();
        $allPermissions = Permission::pluck('id')->toArray();
        foreach ($adminUser as $admin) {
            $admin->permissions()->syncWithoutDetaching($allPermissions);
        }

        // التأكد من أن العلاقة بين الدور والمستخدم لا تُحذف
        if (!DB::table('role_user')->where("user_id", 1)->where("role_id", 1)->exists()) {
            DB::table('role_user')->insert([
                [
                    "role_id" => 1,
                    "user_id" => 1,
                    "user_type" => 'App\Models\Nami\Admin',
                ]
            ]);
        }
    }

    /**
     * Truncates Laratrust tables except permission-user assignments.
     *
     * @param bool $truncatePermissions Whether to truncate permissions or not.
     */
    public function truncateLaratrustTables($truncatePermissions = true)
    {
        $this->command->info('Truncating Role and Permission tables (excluding user assignments)');
        Schema::disableForeignKeyConstraints();

        // لا تحذف الصلاحيات من المستخدمين
        if (Config::get('laratrust_seeder.truncate_tables')) {
            DB::table('roles')->truncate();
            DB::table('permission_role')->truncate();
            DB::table('role_user')->truncate();
            if ($truncatePermissions) {
                DB::table('permissions')->truncate();
            }

            if (Config::get('laratrust_seeder.create_users')) {
                $usersTable = (new \App\Models\User)->getTable();
                DB::table($usersTable)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
