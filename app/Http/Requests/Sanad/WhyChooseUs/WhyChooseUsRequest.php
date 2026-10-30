<?php

namespace App\Http\Requests\Sanad\WhyChooseUs;

use App\Http\Requests\MainRequest;

class WhyChooseUsRequest extends MainRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }

    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            default => [],
        };
    }

    protected function store(): array
    {
        return $this->sharedRules();
    }

    protected function update(): array
    {
        return $this->sharedRules();
    }

    /**
     * @return array<string, mixed>
     */
    private function sharedRules(): array
    {
        return [
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'ar.title' => ['required', 'string', 'max:255'],
            'ar.subtitle' => ['nullable', 'string', 'max:255'],
            'en.title' => ['nullable', 'string', 'max:255'],
            'en.subtitle' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'array'],
            'features.*.ar.title' => ['nullable', 'string', 'max:255'],
            'features.*.en.title' => ['nullable', 'string', 'max:255'],
            'features.*.ar.description' => ['nullable', 'string'],
            'features.*.en.description' => ['nullable', 'string'],
        ];
    }
}
