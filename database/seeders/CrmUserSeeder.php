<?php

namespace Database\Seeders;

use App\Models\CRM\CrmUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CrmUserSeeder extends Seeder
{
    public function run(): void
    {
        CrmUser::updateOrCreate(
            ['email' => 'crm@test.com'],
            [
                'name' => 'CRM Test User',
                'password' => Hash::make('password'),
                'subscription_ends_at' => now()->addYear(),
                'is_active' => true,
            ]
        );
    }
}
