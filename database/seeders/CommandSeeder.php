<?php

namespace Database\Seeders;

use App\Models\Nami\Command;
use Illuminate\Database\Seeder;

class CommandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commands = [
            'php artisan migrate',
            'php artisan migrate --seed',
            'php artisan migrate:fresh --seed',
            'php artisan db:seed',
            'php artisan db:seed --class=LaratrustSeeder',
            'php artisan db:seed --class=LaratrustSeeder --force',
            'php artisan storage:link',
            'php artisan cache:clear',
            'php artisan optimize:clear',
            'php artisan route:cache',
            'php artisan config:cache',
            'php artisan view:clear',
            'php artisan key:generate',
            'php artisan jwt:secret',
        ];

        foreach ($commands as $command) {
            Command::create(['command' => $command]);
        }
    }
}
