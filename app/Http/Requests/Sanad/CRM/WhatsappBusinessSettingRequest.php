<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;

class WhatsappBusinessSettingRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        return [
            'accounts' => ['sometimes', 'array'],
            'accounts.*.id' => ['nullable', 'integer', 'exists:whatsapp_business_settings,id'],
            'accounts.*.name' => ['nullable', 'string', 'max:255'],
            'accounts.*.is_active' => ['nullable', 'boolean'],
            'accounts.*.api_version' => ['nullable', 'string', 'max:50'],
            'accounts.*.phone_number_id' => ['nullable', 'string', 'max:255'],
            'accounts.*.business_account_id' => ['nullable', 'string', 'max:255'],
            'accounts.*.access_token' => ['nullable', 'string', 'max:5000'],
            'accounts.*.webhook_verify_token' => ['nullable', 'string', 'max:255'],
            'accounts.*.app_secret' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'api_version' => ['nullable', 'string', 'max:50'],
            'phone_number_id' => ['nullable', 'string', 'max:255'],
            'business_account_id' => ['nullable', 'string', 'max:255'],
            'access_token' => ['nullable', 'string', 'max:5000'],
            'webhook_verify_token' => ['nullable', 'string', 'max:255'],
            'app_secret' => ['nullable', 'string', 'max:255'],
        ];
    }
}
