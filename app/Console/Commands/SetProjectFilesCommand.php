<?php

namespace App\Console\Commands;

use App\Services\Nami\CommandService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SetProjectFilesCommand extends Command
{
    protected $signature = 'app:set-project-files {projectName?} {--resources} {--blades}';
    protected $description = 'Create Files off Controllers, Requests, Models, Resources Api Class, Service, and Resources blade from migrations';

    public function handle(CommandService $commandService)
    {
        try {
            $projectName = $this->getProjectName();

            // بيجيب كل الميجريشن مع فيلدات توضح ان كان الميجريشن ده خاص ب جدول عادي ولا جدول ترجمة ولا اضافة فيلد لجدول
            $migrations = $this->getMigrations($commandService, $projectName);

            // تشغيل الميجريشن فريش
            $this->processMigrations($commandService, $migrations);

            // انشاء Requests & Controllers
            $this->callMakeCommands($migrations, $projectName);

            // انشاء resources
            if ($this->option('resources')) {
                $this->call('generate:resources', ['projectName' => $projectName]);
            }

            if ($this->option('blades')) {
                $this->callBladeCommand($migrations, $projectName);
            }

            // انشاء المودلز لكل الميجريشن ما عدا ميجريشن تعديل الجداول
            $this->generateModels($migrations, $projectName);

            $this->info("\n 🙌 Models, Services, and controllers generated successfully!");
        } catch (\Exception $e) {
            $this->error("❌  Error occurred: " . $e->getMessage());
        }
    }

    private function getProjectName(): string
    {
        return $this->argument('projectName') ?? 'Nami';
    }

    private function getMigrations(CommandService $commandService, string $projectName): array
    {
        return $commandService->getMigrations($projectName);
    }

    private function processMigrations(CommandService $commandService, array $migrations): void
    {
        $this->output->progressStart(count($migrations));
        $this->output->write("\n");
        $commandService->runMigration();
        $this->output->progressFinish();
    }

    private function generateModels(array $migrations, string $projectName): void
    {
        $projectName = ucfirst($projectName);
        // لو باكدج المودلز موجودة شغلها علطول
        if ($this->commandExists('krlove:generate:model')) {
            foreach ($migrations as $migration) {
                if ($this->shouldGenerateModel($migration)) {
                    $modelName = Str::singular(Str::studly($migration['table']));
                    $this->generateModelClassWithRelation($modelName, $projectName);
                }
            }
        } // لو مش موجودة اسال عاوز يثبتها ولا لا
        else {
            // Ask the user if they want to install the package
            $this->warn("⚠️ The command 'krlove:generate:model' is not available.");
            $install = $this->ask("Would you like to install the package to create model with relations? (yes/no)");

            if (strtolower($install) === 'yes') {
                // Try to install the package using Composer
                $this->info("Attempting to install the package...");

                $success = $this->runComposerInstall();
                if ($success) {
                    $this->warn("🚨 Re-run the command to create the models");
                }
            } else {
                foreach ($migrations as $migration) {
                    if ($this->shouldGenerateModel($migration)) {
                        $modelName = Str::singular(Str::studly($migration['table']));
                        $single_name = Str::singular($migration['table']);
                        $this->generateModelClass($modelName, $projectName, $migration['will_translated'],$single_name);
                    }
                }
            }
        }
    }

    private function shouldGenerateModel(array $migration): bool
    {
        return !$migration['is_edit_migration'];
    }

    private function generateModelClass(string $modelName, string $projectName, $willTranslated,$single_name): void
    {
        $outputPath = app_path("Models/{$projectName}");
        $modelFilePath = "{$outputPath}/{$modelName}.php";

        // Check if the model file already exists
        if (File::exists($modelFilePath)) {
            $this->warn("Hint 🚨 : model '{$modelName}' already exists.");
            return;
        }

        $this->info("Generating Normal model: {$modelName}");

        $projectName = ucfirst($projectName);
        $outputPath = app_path("Models/{$projectName}");
        $modelFilePath = "{$outputPath}/{$modelName}.php";

        if (!File::exists($outputPath)) {
            File::makeDirectory($outputPath, 0755, true);
        }

        $templateContent = $willTranslated ? $this->getTranslationModelTemplate($projectName, $modelName,$single_name) : $this->getStandardModelTemplate($projectName, $modelName);
        File::put($modelFilePath, $templateContent);
        $this->info("Model ✔️: Model '{$modelName}' generated successfully!");
    }

    private function generateModelClassWithRelation(string $modelName, string $projectName): void
    {
        $this->info("🚀 Generating model with relation: {$modelName}");

        $outputPath = app_path("Models/{$projectName}");
        $modelFilePath = "{$outputPath}/{$modelName}.php";
        $customNamespace = "Models/{$projectName}";
        $namespace = "App\\Models\\{$projectName}";

        if (!File::exists($outputPath)) {
            File::makeDirectory($outputPath, 0755, true);
        }


        // Use krlove:generate:model to generate the model
        $this->call('krlove:generate:model', [
            'class-name' => $modelName,
            '--output-path' => $customNamespace,
            '--namespace' => $namespace,
        ]);

        // Optionally, check if the model file exists after generation
        if (File::exists($modelFilePath)) {
            $this->info("Model ✔️: Model '{$modelName}' generated successfully!");
        } else {
            $this->error("Failed to generate model '{$modelName}'.");
        }
    }

    private function runComposerInstall(): bool
    {
        try {
            $this->info("Running Composer install...");
            exec('composer require krlove/eloquent-model-generator', $output, $returnVar);

            if ($returnVar === 0) {
                $this->info("Package installed successfully.");

                // Clear and refresh Laravel cache
                $this->info("Clearing and refreshing Laravel cache...");
                exec('php artisan cache:clear');
                exec('php artisan config:cache');
                exec('php artisan clear-compiled');
                $this->info("Waiting for command registration...");
                sleep(5); // Allow time for command registration
                return true;
            } else {
                $this->error("Failed to install the package.");
                return false;
            }
        } catch (\Exception $e) {
            $this->error("Exception occurred while running Composer install: " . $e->getMessage());
            return false;
        }
    }

    private
    function commandExists(string $commandName): bool
    {
        $commands = $this->getApplication()->all();
        return array_key_exists($commandName, $commands);
    }

    private
    function getStandardModelTemplate(string $projectName, string $modelName): string
    {
        return str_replace(
            ['{{projectName}}', '{{modelName}}'],
            [$projectName, $modelName],
            \App\Utils\models\ModelTemplate::TEMPLATE_CONTENT
        );
    }

    private
    function getTranslationModelTemplate(string $projectName, string $modelName,$single_name): string
    {
        return str_replace(
            ['{{projectName}}', '{{modelName}}','{{single_name}}'],
            [$projectName, $modelName,$single_name],
            \App\Utils\models\ModelTranslationTemplate::TEMPLATE_CONTENT
        );
    }

    private
    function callMakeCommands(array $migrations, string $projectName): void
    {
        foreach ($migrations as $migration) {
            if (!$migration['is_translations'] && !$migration['is_edit_migration']) {
                $modelName = Str::singular(Str::studly($migration['table']));
                $this->callCommands($projectName, $modelName);
            }
        }
    }

    private
    function callCommands(string $projectName, string $modelName): void
    {
        $projectName = ucfirst($projectName);
        $this->call('make:service', ['projectName' => $projectName, 'model' => $modelName]);
        $this->call('generate:controller', ['projectName' => $projectName, 'model' => $modelName]);
        $this->call('generate:request', ['projectName' => $projectName, 'model' => $modelName]);
    }

    private
    function callBladeCommand($migrations, $projectName): void
    {
        foreach ($migrations as $migration) {
            if (!$migration['is_translations'] && !$migration['is_edit_migration']) {
                $bladeName = $migration['table'];
                $this->call('generate:blade', ['projectName' => $projectName, 'bladeName' => $bladeName]);
            }
        }
    }
}
