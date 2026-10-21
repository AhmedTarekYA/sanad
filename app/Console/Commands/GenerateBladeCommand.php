<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Utils\views\EditTemplate;
use App\Utils\views\IndexTemplate;
use App\Utils\views\CreateTemplate;
use Illuminate\Support\Facades\File;

class GenerateBladeCommand extends Command
{
    protected $signature = 'generate:blade {projectName} {bladeName}';
    protected $description = 'Create a folder with Blade templates for index, create, and edit views';

    public function handle()
    {
        $projectName = $this->argument('projectName') ?? 'default-project';
        $bladeName = $this->argument('bladeName');

        $projectName = strtolower($projectName);
        $viewDirectory = resource_path("views/{$projectName}/{$bladeName}");

        // Ensure the directory exists
        $this->createDirectoryIfNeeded($viewDirectory);

        // Generate the Blade view file paths
        $indexFilePath = $this->getBladeFilePath($viewDirectory, 'index.blade.php');
        $createFilePath = $this->getBladeFilePath($viewDirectory, 'create.blade.php');
        $editFilePath = $this->getBladeFilePath($viewDirectory, 'edit.blade.php');

        // Check if any of the files already exist
        if ($this->fileExists($indexFilePath) || $this->fileExists($createFilePath) || $this->fileExists($editFilePath)) {
            $this->warn("Hint 🚨: {$bladeName} Blade already exist");
            return;
        }

        // Generate and write Blade files
        $indexContent = $this->generateBladeContent($bladeName, 'index');
        $createContent = $this->generateBladeContent($bladeName, 'create');
        $editContent = $this->generateBladeContent($bladeName, 'edit');

        $this->writeToFile($indexFilePath, $indexContent);
        $this->writeToFile($createFilePath, $createContent);
        $this->writeToFile($editFilePath, $editContent);

        $this->info("Done 🌎: Blade {$bladeName} Generated successfully !");
    }

    protected function fileExists($fullPath)
    {
        return File::exists($fullPath);
    }

    protected function getBladeFilePath($viewDirectory, $fileName)
    {
        return "{$viewDirectory}/{$fileName}";
    }

    protected function createDirectoryIfNeeded($viewDirectory)
    {
        if (!File::exists($viewDirectory)) {
            File::makeDirectory($viewDirectory, 0755, true);
        }
    }

    protected function generateBladeContent($bladeName, $viewType)
    {
        // Retrieve the template content for different view types
        $templateContent = $this->getTemplateContent($viewType);

        // Replace placeholders with actual values
        return str_replace(
            ['{{bladeName}}'],
            [$bladeName],
            $templateContent
        );
    }

    protected function getTemplateContent($viewType)
    {
        // Map view types to their respective templates
        $templates = [
            'index' => IndexTemplate::TEMPLATE_CONTENT,
            'create' => CreateTemplate::TEMPLATE_CONTENT,
            'edit' => EditTemplate::TEMPLATE_CONTENT
        ];

        return $templates[$viewType] ?? '';
    }

    protected function writeToFile($fullPath, $content)
    {
        File::put($fullPath, $content);
    }
}
