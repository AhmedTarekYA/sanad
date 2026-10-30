<?php

namespace App\Services\Sanad;

use App\Models\Sanad\Faq;
use App\Services\MainService;

class FaqService extends MainService
{
    public function __construct(Faq $model)
    {
        $this->model = $model;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function getDataTable()
    {
        return $this->model->query()
            ->with('translations')
            ->orderBy('sort_order');
    }

    public function storeFaq(array $data): Faq
    {
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);

        return Faq::create(array_merge($data, $translations));
    }

    public function updateFaq(int $id, array $data): void
    {
        $faq = $this->find($id);
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);

        $faq->update(array_merge($data, $translations));
    }

    /** @return array<string, array<string, string>> */
    private function extractTranslations(array &$data): array
    {
        $translations = [];

        foreach (config('translatable.locales') as $locale) {
            if (isset($data[$locale]) && is_array($data[$locale])) {
                $translations[$locale] = $data[$locale];
                unset($data[$locale]);
            }
        }

        return $translations;
    }
}
