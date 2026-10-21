<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class SystemUpdate extends Command
{
    protected $signature = 'system:update';
    protected $description = 'Pull latest updates from GitHub and refresh commit hash';

    public function handle()
    {
        $this->info("🔄 Starting update...");

        // --- Prepare Git Pull Command ---
        $repoUrl = sprintf(
            "https://%s:%s@github.com/%s/%s.git",
            env('GITHUB_PROVIDER', 'Nami-BackEnd'),
            env('GITHUB_TOKEN'),
            env('GITHUB_PROVIDER', 'Nami-BackEnd'),
            env('GITHUB_REPO'),
        );

        $branch = env('GITHUB_BRANCH', 'main');
        $command = ["git", "pull", $repoUrl, $branch];

        $process = new Process($command, base_path());
        $process->setTimeout(3600);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $e) {
            Log::channel('system_update')->error("Git Pull Failed", ['error' => $e->getMessage()]);
            $this->error("❌ Git Pull Failed:");
            return Command::FAILURE;
        }

        $output = $process->getOutput();

        Log::channel('system_update')->info("Git Pull Output", ['output' => $output]);
        $this->line($output);

        // --------------------------------------------------------------------
        // 🔍 STEP 1 — Check for pending migrations
        // --------------------------------------------------------------------
        $this->info("🔍 Checking for pending migrations...");

        $pendingMigrations = $this->getPendingMigrations();

        if (count($pendingMigrations) > 0) {
            $this->info("🟨 Pending migrations found: " . count($pendingMigrations));

            Log::channel('system_update')->info("Pending migrations detected", [
                "migrations" => $pendingMigrations
            ]);

            // Run migration
            $this->runMigrations();
        } else {
            $this->info("✔ No new migrations. Skipping migrate.");
        }

        // --------------------------------------------------------------------
        // 🧹 STEP 2: optimize:clear
        // --------------------------------------------------------------------
        $this->info("🧹 Clearing caches...");
        Artisan::call('optimize:clear');
        $this->line(Artisan::output());

        // --------------------------------------------------------------------
        // 🟩 STEP 3: Save commit hash
        // --------------------------------------------------------------------
        $newHash = trim(shell_exec("cd " . base_path() . " && git rev-parse HEAD"));

        if ($newHash) {
            file_put_contents(storage_path('app/current_commit.txt'), $newHash);
            Log::channel('system_update')->info("Updated Commit Saved", ['commit' => $newHash]);
            $this->info("📝 Updated commit saved: " . $newHash);
        } else {
            Log::channel('system_update')->error("Failed to fetch new commit hash");
            $this->error("❌ Failed to get commit hash");
        }

        return Command::SUCCESS;
    }

    // ------------------------------------------------------------
    // 🔍 Check pending migrations
    // ------------------------------------------------------------
    private function getPendingMigrations()
    {
        $migrationPath = database_path('migrations');

        $allMigrations = collect(scandir($migrationPath))
            ->filter(fn($file) => str_ends_with($file, '.php'))
            ->values()
            ->toArray();

        $ranMigrations = Schema::hasTable('migrations')
            ? \DB::table('migrations')->pluck('migration')->toArray()
            : [];

        return array_diff(
            array_map(fn($file) => pathinfo($file, PATHINFO_FILENAME), $allMigrations),
            $ranMigrations
        );
    }

    // ------------------------------------------------------------
    // 🚀 Run migrations safely
    // ------------------------------------------------------------
    private function runMigrations()
    {
        try {
            $this->info("🔧 Running migrations...");
            Artisan::call('migrate', ['--force' => true]);

            Log::channel('system_update')->info("Migration Output", [
                'output' => Artisan::output()
            ]);

            $this->line(Artisan::output());
        } catch (\Exception $e) {
            Log::channel('system_update')->error("Migration Failed", [
                'error' => $e->getMessage()
            ]);
            $this->error("❌ Migration failed!");
        }
    }
}
