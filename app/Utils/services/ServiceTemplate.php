<?php

namespace App\Utils\services;

class ServiceTemplate
{
    public const TEMPLATE_CONTENT = <<<PHP
<?php

namespace App\\Services\\{{projectName}};

use App\Services\\MainService;
use App\\Models\\{{modelFullName}};

class {{serviceClassName}} extends MainService
{
    public function __construct({{modelName}} \$model)
    {
        \$this->model = \$model;
        \$this->fileFolder = 'images/{{modelName}}/';
        // pass the files that want to save
        \$this->files = ['image'];
    }

}
PHP;
}
