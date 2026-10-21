<?php

namespace App\Http\Requests\Nami\Permission;

use App\Http\Requests\MainRequest;

class PermissionRequest extends MainRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy(),
            default => $this->view()
        };

    }

    protected function store(): array
    {
        return [
           "name" => 'required|string',
           'display_name' => 'required|string',
           'description' => 'required|string',
           'description_ar' => 'required|string'
        ];
    }

    protected function update(): array
    {
        return [
            "name" => 'nullable|string',
            'display_name' => 'nullable|string',
            'description' => 'required|string',
            'description_ar' => 'required|string'
        ];
    }

    protected function destroy(): array
    {
        return [];
    }

    protected function view(): array
    {
        return [];
    }
}
