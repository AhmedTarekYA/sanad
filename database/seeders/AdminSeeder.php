<?php

namespace Database\Seeders;

use App\Enums\AdminTypeisEnum;
use App\Models\Sanad\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Sanad',
                'phone' => '01000000000',
                'password' => bcrypt('123456'),
                'admin_type' => AdminTypeisEnum::GlobalManger->value,
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'dev@dev.com'],
            [
                'name' => 'Developer',
                'phone' => '01000000001',
                'password' => bcrypt('123456'),
                'admin_type' => AdminTypeisEnum::Developer->value,
            ]
        );
    }
}
