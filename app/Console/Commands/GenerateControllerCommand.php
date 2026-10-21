<?php

namespace App\Console\Commands;

use App\Utils\controllers\ControllerTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateControllerCommand extends Command
{
    protected $signature = 'generate:controller {projectName} {model}';
    protected $description = 'Generate a new controller class';

    public function handle()
    {
        $projectName = $this->argument('projectName');
        $modelName = $this->argument('model');
        $namespace = "App\\Http\\Controllers\\{$projectName}";
        $controllerClassName = $this->getNameConcatenated($modelName,'Controller');
        $objService = $this->getNameConcatenated($modelName,'Service');
        $objRequest = $this->getNameConcatenated($modelName,'Request');
        $fullPath = $this->getControllerClassFullPath($projectName, $controllerClassName);

        if ($this->fileExists($fullPath)) {
            $this->warn("Hint 🚨: Controller {$namespace}\\{$controllerClassName} already exists!");
            return;
        }

        $this->createDirectoryIfNeeded($fullPath);

        $folderPath = strtolower($projectName) . "." . Str::snake($modelName);
        $mainRoute = Str::snake($modelName);

        $content = $this->generateControllerClassContent($projectName,$objService, $objRequest,$controllerClassName, $folderPath, $mainRoute);
        $this->writeToFile($fullPath, $content);

        $this->info("Done 🚀: Controller '{$controllerClassName}' Created successfully!");
    }

    protected function fileExists($fullPath)
    {
        return File::exists($fullPath);
    }


    public function getNameConcatenated($modelName,$type)
    {
        return $modelName.$type;
    }

    protected function getControllerClassFullPath($projectName, $controllerClassName)
    {
        return app_path("Http/Controllers/{$projectName}/{$controllerClassName}.php");
    }

    protected function createDirectoryIfNeeded($fullPath)
    {
        File::makeDirectory(dirname($fullPath), 0755, true, true);
    }

    protected function generateControllerClassContent($projectName, $objService, $objRequest, $controllerClassName, $folderPath, $mainRoute)
    {
        // Retrieve the template content from the ControllerTemplate class
        $templateContent = ControllerTemplate::TEMPLATE_CONTENT;

        // Replace placeholders with actual values
        $content = str_replace(
            ['{{projectName}}', '{{objService}}', '{{objRequest}}', '{{controllerClassName}}', '{{folderPath}}', '{{mainRoute}}'],
            [$projectName, $objService, $objRequest, $controllerClassName, $folderPath, $mainRoute],
            $templateContent
        );

        return $content;
    }

    protected function writeToFile($fullPath, $content)
    {
        File::put($fullPath, $content);
    }
}
