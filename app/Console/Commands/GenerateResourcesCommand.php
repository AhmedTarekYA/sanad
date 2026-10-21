<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;




class GenerateResourcesCommand extends Command
{
    protected $signature = 'generate:resources {projectName}';

    protected $description = 'Generate resource classes for all migrations';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $projectName = $this->argument('projectName') ?? 'nami';
        $path = database_path('migrations/'.$projectName);
        $files = scandir($path);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Extract the main name without the timestamp
                $migrationName = $this->getMigrationName($file);
                // Convert the migration name to snake_case to get the table name
                $tableName = Str::snake($migrationName);
                // Check if the table exists before getting the column listing
                if (Schema::hasTable($tableName)) {
                    // Get the columns from the migration table
                    $columns = Schema::getColumnListing($tableName);


                    // Make sure migration name is not empty
                    if (!empty($migrationName)) {
                        $migrationNameSingle = Str::singular(Str::studly($migrationName));
                        $resourceClassName = Str::studly($migrationNameSingle) . 'Resource';
                        $resourceClassPath = app_path("Http/Resources/{$resourceClassName}.php");

                        // Check if the resource class already exists
                       // App\Http\Resources\CertificationResource;
                        if (!File::exists($resourceClassPath)) {
                            // Generate a resource class
                            if (!$this->isTranslationTable($migrationName)) {
                                Artisan::call("make:resource {$resourceClassName}");

                                // Customize the generated resource class
                                $this->customizeResourceClass($resourceClassName, $migrationName,$tableName);

                                $this->info("Done ✌️: Resource {$resourceClassName} Created successfully");
                            }
                        }
                        else{
                            $this->warn("Hint 🚨: Resource {$resourceClassName} already exists!");
                        }
                    }
                }
            }
        }
    }
    protected function isTranslationTable($modelName)
    {
        return stripos($modelName, 'translation') !== false;
    }


    protected function getMigrationName($filename)
    {
        // Use regular expression to extract the main name without the timestamp
        if (preg_match('/^(\d{4}_\d{2}_\d{2}_\d{6})_(.+)\.php$/', $filename, $matches)) {
            $migrationName = $matches[2];
            $migrationName = preg_replace('/_table$/', '', $migrationName);

            // Remove common prefixes like 'create_', 'update_', 'delete_'
            $commonPrefixes = ['create_', 'update_', 'delete_'];
            foreach ($commonPrefixes as $prefix) {
                if (Str::startsWith($migrationName, $prefix)) {
                    $migrationName = Str::after($migrationName, $prefix);
                }
            }

            return $migrationName;
        }

        return null;
    }

    protected function customizeResourceClass($resourceClassName, $migrationName,$tableName)
    {
        // Path to the generated resource class
        $resourceClassPath = app_path("Http/Resources/{$resourceClassName}.php");

        // Get the columns from the migration table
        $columns = Schema::getColumnListing(Str::snake($migrationName));
//        $column_type = Schema::getColumnType('users','updated_at');
//dd($column_type);
        // Generate the dynamic toArray method
        $dynamicToArray = $this->generateDynamicToArray($columns,$tableName);

        // Replace the existing toArray method with the dynamic one
        file_put_contents(
            $resourceClassPath,
            preg_replace('/public function toArray\(.*\)/s', $dynamicToArray, file_get_contents($resourceClassPath))
        );
    }

    protected function generateDynamicToArray($columns,$tableName)
    {
        $toArray = 'public function toArray($request)
        {
        return [';

        foreach ($columns as $column) {
            $column_type = in_array(Schema::getColumnType($tableName,$column), ['bigint','int','double','boolean'])?
                Schema::getColumnType($tableName,$column) : 'string';
            if($column_type == 'bigint'){
                $column_type = 'int';
            }

            $toArray .= "\n\t\t\t'{$column}' => ({$column_type})\$this->{$column},";
        }

        $toArray .= "\n\t\t]";

        return $toArray;
    }
}
