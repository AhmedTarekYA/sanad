<?php

namespace App\Http\Requests\Config;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class ConfigRequest extends MainRequest
{
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy(),
            'GET' => $this->view(),
            default => [],
        };
    }

    protected function store(): array
    {
        return [
            // Add your validation rules for storing resources here
            'code' => [
                'required',
                'regex:/^[A-Za-z][A-Za-z0-9]{0,31}$/',
                'unique:configs,code',
            ],
            'name' => [
                'required',
                'regex:/^[A-Za-z][A-Za-z0-9]*$/',
                'unique:configs,name'
            ],
            'is_dev' => 'nullable|boolean',
            'is_maintenance' => 'nullable|boolean',
            'force_update' => 'nullable|boolean',
            'show_dialog' => 'nullable|boolean',
            'latest_version_android' => 'required|string|max:255',
            'latest_version_ios' => 'required|string|max:255',
            'api_base_url' => 'required|url',
            'api_image_base_url' => 'required|url',
            'enable_payment' => 'nullable|boolean',
            'welcome_message' => 'nullable|string',
            'update_message' => 'nullable|string',
            'maintenance_message' => 'nullable|string',
            'force_update_message' => 'nullable|string',
            'maps_api_key' => 'required|string|max:255',

        ];
    }

    protected function update(): array
    {
        $config_id = $this->route()->parameter('config');
        return [
            // Add your validation rules for updating resources here
            'code' => [
                'required',
                'regex:/^[A-Za-z][A-Za-z0-9]{0,31}$/',
                'unique:configs,code,' . $config_id,
            ],
            'name' => [
                'required',
                'regex:/^[A-Za-z][A-Za-z0-9]*$/',
                'unique:configs,name,' . $config_id,
            ],
            'is_dev' => 'nullable|boolean',
            'is_maintenance' => 'nullable|boolean',
            'force_update' => 'nullable|boolean',
            'show_dialog' => 'nullable|boolean',
            'latest_version_android' => 'required|string|max:255',
            'latest_version_ios' => 'required|string|max:255',
            'api_base_url' => 'required|url',
            'api_image_base_url' => 'required|url',
            'enable_payment' => 'nullable|boolean',
            'welcome_message' => 'nullable|string',
            'update_message' => 'nullable|string',
            'maintenance_message' => 'nullable|string',
            'force_update_message' => 'nullable|string',
            'maps_api_key' => 'required|string|max:255',

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
