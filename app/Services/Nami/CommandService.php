<?php

namespace App\Services\Nami;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CommandService
{
    public function __construct()
    {
        // Initialization if needed
    }

    public function getMigrations(string $folderName): array
    {
        $path = database_path("migrations/{$folderName}");
        $this->checkFolderExist($path);

        $migrations = [];
        foreach (scandir($path) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $path . DIRECTORY_SEPARATOR . $file;
            if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                try {
                    $fileContent = File::get($filePath);
                } catch (\Exception $e) {
                    throw new \Exception("Failed to read file {$filePath}: " . $e->getMessage());
                }

                $tableName = $this->extractTableName($fileContent);

                $migrations[] = [
                    'file' => $file,
                    'table' => $tableName,
                    'is_edit_migration' => !$this->isCreateTableMigration($file),
                    'is_translations' => str_contains($file, 'translations'),
                    'will_translated' => $this->checkWillTranslatedTable($tableName,$path),
                ];
            }
        }

        return $migrations;
    }

    private function extractTableName(string $fileContent): ?string
    {
        if (preg_match('/Schema::create\(\'([^\']+)\',/', $fileContent, $matches)) {
            return $matches[1];
        } elseif (preg_match('/Schema::table\(\'([^\']+)\',/', $fileContent, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function isCreateTableMigration(string $fileName): bool
    {
        return preg_match('/create_(\w+)_table/i', pathinfo($fileName, PATHINFO_FILENAME));
    }

    public function checkWillTranslatedTable(string $tableName, string $path)
    {
        // List of possible names for the table
        $possibleNames = [
            $tableName,
            Str::singular(Str::studly($tableName)),
            Str::singular($tableName),
            Str::plural($tableName),
        ];

        // Construct the regex pattern for the translation table
        $pattern = '/create_(\w+)_translations_table/i';

        // Get all files in the directory
        $files = array_diff(scandir($path), ['.', '..']);

        foreach ($files as $file) {
            $filePath = $path . DIRECTORY_SEPARATOR . $file;

            // Check if the file is a PHP file and not a directory
            if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Check if the filename matches the translation table pattern
                if (preg_match($pattern, pathinfo($file, PATHINFO_FILENAME), $matches)) {
                    $tableNameFromFile = $matches[1];

                    // Verify if the table name from the file matches one of the possible names
                    if (in_array($tableNameFromFile, $possibleNames)) {
                        return $tableNameFromFile . '_translations';
                    }
                }
            }
        }

        return null;
    }

    public
        function runMigration(): void
        {
            try {
                Artisan::call('migrate:fresh', ['--seed' => true]);
            } catch (\Exception $e) {
                throw new \Exception("Migration failed: " . $e->getMessage());
            }
        }


        public
        function generateModels(): void
        {
            // Implementation needed
        }

        public
        function checkFolderExist(string $path): void
        {
            if (!File::isDirectory($path)) {
                throw new \Exception("Directory does not exist: {$path}");
            }

            // Check if the directory is empty
            $files = array_diff(scandir($path), ['.', '..']);
            if (empty($files)) {
                throw new \Exception("Directory {$path} is empty");
            }
        }
    }
