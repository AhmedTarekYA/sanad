<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class CrmUserRequest extends MainRequest
{
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            default => [],
        };
    }

    /** @return array<string, array<int, mixed>> */
    protected function store(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('crm_users', 'email')],
            'password' => ['required', 'string', 'min:6'],
            'subscription_ends_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /** @return array<string, array<int, mixed>> */
    protected function update(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('crm_users', 'email')->ignore($this->route('id'))],
            'password' => ['nullable', 'string', 'min:6'],
            'subscription_ends_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
