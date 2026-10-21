<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTranslationSeeder extends Seeder
{
    private array $translations = [
        'admins-create' => 'إضافة مشرف',
        'admins-read' => 'عرض المشرفين',
        'admins-update' => 'تعديل مشرف',
        'admins-delete' => 'حذف مشرف',
        'roles-create' => 'إضافة دور',
        'roles-read' => 'عرض الأدوار',
        'roles-update' => 'تعديل دور',
        'roles-delete' => 'حذف دور',
        'settings-create' => 'إضافة إعداد',
        'settings-read' => 'عرض الإعدادات',
        'settings-update' => 'تعديل إعداد',
        'settings-delete' => 'حذف إعداد',
        'profile-read' => 'عرض الملف الشخصي',
        'profile-update' => 'تعديل الملف الشخصي',
        'change-password-read' => 'عرض تغيير كلمة المرور',
        'change-password-update' => 'تغيير كلمة المرور',
    ];

    public function run(): void
    {
        foreach ($this->translations as $name => $descriptionAr) {
            Permission::where('name', $name)->update(['description_ar' => $descriptionAr]);
        }

        $this->command->info('Permission Arabic translations updated.');
    }
}
