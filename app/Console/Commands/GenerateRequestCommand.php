<?php

namespace App\Console\Commands;

use App\Utils\requests\RequestTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateRequestCommand extends Command
{
    protected $signature = 'generate:request {projectName} {model}';
    protected $description = 'Generate a new request class';

    public function handle()
    {
        $projectName = $this->argument('projectName');
        $modelName = $this->argument('model');

        // Generate request class name and file path
        $requestClassName = Str::studly($modelName) . 'Request';
        $namespace = "App\\Http\\Requests\\{$projectName}";
        $filePath = $this->getRequestClassFullPath($projectName, $requestClassName);

        // Check if the file already exists
        if (File::exists($filePath)) {
            $this->warn("Hint 🚨: Request class {$requestClassName} already exists!");
            return;
        }

        // Create directory if needed
        $this->createDirectoryIfNeeded($filePath);

        // Generate request class content
        $content = $this->generateRequestClassContent($projectName, $requestClassName);

        // Write content to the file
        File::put($filePath, $content);

        $this->info("Done ✔️: 'Request {$requestClassName}' Created successfully!");
    }

    protected function getRequestClassFullPath($projectName, $requestClassName)
    {
        return app_path("Http/Requests/{$projectName}/{$requestClassName}.php");
    }

    protected function createDirectoryIfNeeded($fullPath)
    {
        $directory = dirname($fullPath);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    protected function generateRequestClassContent($projectName, $requestClassName)
    {
        // Retrieve the template content from the RequestTemplate class
        $templateContent = RequestTemplate::TEMPLATE_CONTENT;

        // Replace placeholders with actual values
        return str_replace(
            ['{{projectName}}', '{{requestName}}'],
            [$projectName, $requestClassName],
            $templateContent
        );
    }
}
