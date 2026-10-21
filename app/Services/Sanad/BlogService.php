<?php

namespace App\Services\Sanad;

use App\Models\Sanad\Blog;
use App\Services\MainService;

class BlogService extends MainService
{
    public function __construct(Blog $model)
    {
        $this->model = $model;
        $this->fileFolder = 'images/blogs/';
        $this->files = ['image'];
    }

    public function storeBlog(array $data): Blog
    {
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);

        return Blog::create(array_merge($data, $translations));
    }

    public function updateBlog(int $id, array $data): void
    {
        $blog = $this->find($id);
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);

        $blog->update(array_merge($data, $translations));
    }

    /** @return array<string, array<string, string>> */
    private function extractTranslations(array &$data): array
    {
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            if (isset($data[$locale])) {
                $translations[$locale] = $data[$locale];
                unset($data[$locale]);
            }
        }

        return $translations;
    }
}
