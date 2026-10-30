<?php

namespace App\Services\Sanad;

use App\Models\Sanad\ClientReview;
use App\Services\MainService;

class ClientReviewService extends MainService
{
    public function __construct(ClientReview $model)
    {
        $this->model = $model;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function getDataTable()
    {
        return $this->model->query()
            ->with('translations')
            ->latest();
    }

    public function storeReview(array $data): ClientReview
    {
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);

        return ClientReview::create(array_merge($data, $translations));
    }

    public function updateReview(int $id, array $data): void
    {
        $review = $this->find($id);
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);

        $review->update(array_merge($data, $translations));
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
