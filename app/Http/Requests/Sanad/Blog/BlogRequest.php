<?php

namespace App\Http\Requests\Sanad\Blog;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends MainRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(['is_featured' => $this->boolean('is_featured')]);
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
        return [
            'image' => ['nullable', 'image'],
            'is_featured' => ['boolean'],
            'ar.title' => ['required', 'string', 'max:255'],
            'ar.slug' => ['required', 'string', 'max:255', 'unique:blog_translations,slug'],
            'ar.description' => ['nullable', 'string'],
            'en.title' => ['nullable', 'string', 'max:255'],
            'en.slug' => ['nullable', 'string', 'max:255', 'unique:blog_translations,slug'],
            'en.description' => ['nullable', 'string'],
        ];
    }

    protected function update(): array
    {
        $id = $this->route('id');

        return [
            'image' => ['nullable', 'image'],
            'is_featured' => ['boolean'],
            'ar.title' => ['required', 'string', 'max:255'],
            'ar.slug' => ['required', 'string', 'max:255', Rule::unique('blog_translations', 'slug')->where('locale', 'ar')->ignore($id, 'blog_id')],
            'ar.description' => ['nullable', 'string'],
            'en.title' => ['nullable', 'string', 'max:255'],
            'en.slug' => ['nullable', 'string', 'max:255', Rule::unique('blog_translations', 'slug')->where('locale', 'en')->ignore($id, 'blog_id')],
            'en.description' => ['nullable', 'string'],
        ];
    }
}
