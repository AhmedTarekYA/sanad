<?php

namespace App\Utils\models;

class ModelTemplate
{
    public const TEMPLATE_CONTENT = <<<PHP
<?php

namespace App\\Models\\{{projectName}};

use Illuminate\\Database\\Eloquent\\Model;

class {{modelName}} extends Model
{
    protected \$guarded = [];
}
PHP;
}
