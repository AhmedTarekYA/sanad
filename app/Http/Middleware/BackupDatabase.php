<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\Nami\Backup;
use Carbon\Carbon;

class BackupDatabase
{
    public function handle(Request $request, Closure $next)
    {
        $today = Carbon::today()->toDateString();
        if (!Backup::where('backup_date', $today)->exists()) {
            $backupFile = "backup-{$today}.sql";
            $backupPath = storage_path("app/public/backups/{$backupFile}");
            if (!Storage::disk('public')->exists('backups')) {
                Storage::disk('public')->makeDirectory('backups');
            }
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_HOST'),
                env('DB_DATABASE'),
                $backupPath
            );
            exec($command);
            Backup::create(['backup_date' => $today]);
        }
        $this->deleteOldBackups();
        return $next($request);
    }

    private function deleteOldBackups()
    {
        $dateLimit = Carbon::today()->subDays(7)->toDateString();
        $oldBackups = Backup::where('backup_date', '<', $dateLimit)->get();
        foreach ($oldBackups as $backup) {
            $backupFile = "backup-{$backup->backup_date}.sql";
            $backupPath = storage_path("app/public/backups/{$backupFile}");
            if (file_exists($backupPath)) {
                unlink($backupPath);
            }
            $backup->delete();
        }
    }
}
