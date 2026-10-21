<?php

namespace App\Http\Requests\Sanad\Blog;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends MainRequest
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
        return [
            'slug' => ['required', 'string', 'max:255', 'unique:blogs,slug'],
            'image' => ['nullable', 'image'],
            'ar.title' => ['required', 'string', 'max:255'],
            'en.title' => ['nullable', 'string', 'max:255'],
            'ar.description' => ['nullable', 'string'],
            'en.description' => ['nullable', 'string'],
        ];
    }

    protected function update(): array
    {
        return [
            'slug' => ['required', 'string', 'max:255', Rule::unique('blogs', 'slug')->ignore($this->route('id'))],
            'image' => ['nullable', 'image'],
            'ar.title' => ['required', 'string', 'max:255'],
            'en.title' => ['nullable', 'string', 'max:255'],
            'ar.description' => ['nullable', 'string'],
            'en.description' => ['nullable', 'string'],
        ];
    }
}
