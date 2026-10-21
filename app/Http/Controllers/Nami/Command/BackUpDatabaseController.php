<?php

namespace App\Http\Controllers\Nami\Command;

use App\Services\Nami\CommandTerminalService as objService;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
class BackUpDatabaseController extends Controller
{
    public function index() {
        $timestamp = date('Y_m_d_His');
        $backupFilePath = storage_path("app/public/backups/database_backup_{$timestamp}.sql");

        $dbName = env('DB_DATABASE');
        $dbUsername = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');

        if (!file_exists(dirname($backupFilePath))) {
            mkdir(dirname($backupFilePath), 0755, true);
        }

        $command = "mysqldump -u {$dbUsername} -p{$dbPassword} {$dbName} > " . escapeshellarg($backupFilePath);
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            return response()->json(['error' => 'Failed to create database backup.'], 500);
        }

        if (file_exists($backupFilePath)) {
            return Response::download($backupFilePath, "database_backup_{$timestamp}.sql");
        } else {
            return response()->json(['error' => 'Backup file not found'], 404);
        }
    }

}
