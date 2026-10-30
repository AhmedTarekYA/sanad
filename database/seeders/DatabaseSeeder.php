<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(PermissionTranslationSeeder::class);
        $this->call(CommandSeeder::class);
        $this->call(WebsiteBlogSeeder::class);
        $this->call(ConsultationRequestSeeder::class);
        $this->call(WhyChooseUsSeeder::class);
        $this->call(ClientReviewSeeder::class);
        $this->call(FaqSeeder::class);
    }
}
