<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {projectName} {model}';
    protected $description = 'Create a new service class for a model';

    public function handle()
    {
        $projectName = $this->argument('projectName') ?? 'nami';
        $modelName = $this->argument('model');

        $namespace = "App\Services\\{$projectName}";
        $serviceClassName = $this->getServiceClassName($modelName);

        $fullPath = $this->getServiceClassFullPath($projectName, $serviceClassName);

        if ($this->fileExists($fullPath)) {
            $this->warn("Hint 🚨 : Class {$namespace}\\{$serviceClassName} already exists!");
            return;
        }

        $this->createDirectoryIfNeeded($fullPath);

        $modelFullName = $this->getModelFullName($modelName, $projectName);
        $content = $this->generateServiceClassContent($projectName, $modelFullName, $modelName, $serviceClassName);
        $this->writeToFile($fullPath, $content);

        $this->info("Done 🟢: Service Class '{$serviceClassName}' Created successfully!");
    }

    protected function fileExists($fullPath)
    {
        return File::exists($fullPath);
    }

    protected function getServiceClassName($modelName)
    {
        return $modelName . 'Service';
    }

    protected function getServiceClassFullPath($projectName, $serviceClassName)
    {
        return app_path("Services/{$projectName}/{$serviceClassName}.php");
    }

    protected function createDirectoryIfNeeded($fullPath)
    {
        File::makeDirectory(dirname($fullPath), 0755, true, true);
    }

    protected function classExists($namespace, $serviceClassName)
    {
        return File::exists(app_path("Services/{$namespace}/{$serviceClassName}.php"));
    }

    protected function getModelFullName($modelName, $projectName)
    {
        return "{$projectName}\\{$modelName}";
    }


    protected function generateServiceClassContent($projectName, $modelFullName, $modelName, $serviceClassName)
    {
        // Retrieve the template content from the ServiceTemplate class
        $templateContent = \App\Utils\services\ServiceTemplate::TEMPLATE_CONTENT;

        // Replace placeholders with actual values
        $content = str_replace(
            ['{{projectName}}', '{{modelFullName}}', '{{modelName}}', '{{serviceClassName}}'],
            [$projectName, $modelFullName, $modelName, $serviceClassName],
            $templateContent
        );

        return $content;
    }

    protected function writeToFile($fullPath, $content)
    {
        File::put($fullPath, $content);
    }
}

