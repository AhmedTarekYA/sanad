<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SaveCurrentCommit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:save-current-commit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save current deployed commit hash';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hash = trim(shell_exec('git rev-parse HEAD'));
        file_put_contents(storage_path('app/current_commit.txt'), $hash);

        $this->info("Saved commit: $hash");
    }
}
