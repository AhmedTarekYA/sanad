<?php

namespace App\Services\Sanad;

use App\Models\Sanad\WhyChooseUs;
use App\Models\Sanad\WhyChooseUsFeature;
use App\Services\MainService;
use Illuminate\Support\Facades\DB;

class WhyChooseUsService extends MainService
{
    public function __construct(WhyChooseUs $model)
    {
        $this->model = $model;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function getDataTable()
    {
        return $this->model->query()
            ->with(['translations', 'features.translations'])
            ->orderBy('sort_order');
    }

    public function storeCard(array $data): WhyChooseUs
    {
        $features = $this->extractFeatures($data);
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return DB::transaction(function () use ($data, $translations, $features) {
            $card = WhyChooseUs::create(array_merge($data, $translations));
            $this->syncFeatures($card, $features);

            return $card;
        });
    }

    public function updateCard(int $id, array $data): void
    {
        $card = $this->find($id);
        $features = $this->extractFeatures($data);
        $translations = $this->extractTranslations($data);
        $data = $this->clearRequest($data);
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        DB::transaction(function () use ($card, $data, $translations, $features) {
            $card->update(array_merge($data, $translations));
            $card->features()->delete();
            $this->syncFeatures($card, $features);
        });
    }

    /**
     * @param  array<int, array<string, mixed>>  $features
     */
    private function syncFeatures(WhyChooseUs $card, array $features): void
    {
        $order = 0;

        foreach ($features as $feature) {
            $translations = [];

            foreach (config('translatable.locales') as $locale) {
                $title = trim((string) ($feature[$locale]['title'] ?? ''));

                if ($title === '') {
                    continue;
                }

                $translations[$locale] = [
                    'title' => $title,
                    'description' => $feature[$locale]['description'] ?? null,
                ];
            }

            if (empty($translations)) {
                continue;
            }

            /** @var WhyChooseUsFeature $featureModel */
            $featureModel = $card->features()->create(['sort_order' => $order++]);
            $featureModel->fill($translations)->save();
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function extractFeatures(array &$data): array
    {
        $features = $data['features'] ?? [];
        unset($data['features']);

        return is_array($features) ? $features : [];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
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
