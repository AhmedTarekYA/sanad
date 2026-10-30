<?php

namespace App\Http\Requests\Sanad\ClientReview;

use App\Http\Requests\MainRequest;

class ClientReviewRequest extends MainRequest
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
            'ar.name' => ['required', 'string', 'max:255'],
            'ar.job' => ['nullable', 'string', 'max:255'],
            'ar.company_name' => ['nullable', 'string', 'max:255'],
            'ar.review_message' => ['required', 'string'],
            'en.name' => ['nullable', 'string', 'max:255'],
            'en.job' => ['nullable', 'string', 'max:255'],
            'en.company_name' => ['nullable', 'string', 'max:255'],
            'en.review_message' => ['nullable', 'string'],
        ];
    }
}
