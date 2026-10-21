<?php

namespace App\Utils\requests;

class RequestTemplate
{
    public const TEMPLATE_CONTENT = <<<PHP
<?php

namespace App\\Http\\Requests\\{{projectName}};

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class {{requestName}} extends MainRequest
{
    public function rules(): array
    {
        return match (\$this->method()) {
            'POST' => \$this->store(),
            'PUT', 'PATCH' => \$this->update(),
            'DELETE' => \$this->destroy(),
            'GET' => \$this->view(),
            default => [],
        };
    }

    protected function store(): array
    {
        return [
            // Add your validation rules for storing resources here

        ];
    }

    protected function update(): array
    {
        return [
            // Add your validation rules for updating resources here

        ];
    }

    protected function destroy(): array
    {
        return [
            // Add your validation rules for deleting resources here
        ];
    }

    protected function view(): array
    {
        return [
            // Add your validation rules for viewing resources here
        ];
    }
}
PHP;
}
