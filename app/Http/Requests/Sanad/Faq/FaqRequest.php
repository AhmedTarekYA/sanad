<?php

namespace App\Http\Requests\Sanad\Faq;

use App\Http\Requests\MainRequest;

class FaqRequest extends MainRequest
{
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
        return $this->baseRules();
    }

    protected function update(): array
    {
        return $this->baseRules();
    }

    /** @return array<string, array<int, string>> */
    protected function baseRules(): array
    {
        return [
            'ar.question' => ['required', 'string', 'max:500'],
            'ar.answer' => ['required', 'string'],
            'en.question' => ['nullable', 'string', 'max:500'],
            'en.answer' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
