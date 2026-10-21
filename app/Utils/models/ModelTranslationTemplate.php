<?php

namespace App\Utils\models;

class ModelTranslationTemplate
{
    public const TEMPLATE_CONTENT = <<<PHP
<?php

namespace App\\Models\\{{projectName}};

use Illuminate\\Database\\Eloquent\\Model;
use Astrotomic\\Translatable\\Translatable;
use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;

class {{modelName}} extends Model
{
    use Translatable, HasFactory;

    protected \$with = ['translations'];

    protected \$translationForeignKey = '{{single_name}}_id';

    public \$translationModel = {{modelName}}Translation::class;

    public \$translatedAttributes = [];

    protected \$guarded = [];
}
PHP;
}
