<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->exists('service_interest') && $this->exists('serviceInterest')) {
            $this->merge(['service_interest' => $this->input('serviceInterest')]);
        }
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'mobile_whatsapp' => ['required', 'string', 'max:255'],
            'daily_contact_volume' => ['required', 'string', 'max:255'],
            'current_systems' => ['nullable', 'string', 'max:500'],
            'service_interest' => ['nullable', 'string', 'max:255'],
        ];
    }
}
