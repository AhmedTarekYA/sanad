<?php

namespace Database\Seeders;

use App\Models\Sanad\WhyChooseUs;
use App\Models\Sanad\WhyChooseUsFeature;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'ar' => ['title' => 'Sanad CX', 'subtitle' => 'شريك النمو'],
                'en' => ['title' => 'Sanad CX', 'subtitle' => 'Growth Partner'],
                'is_featured' => true,
                'sort_order' => 1,
                'features' => [
                    [
                        'sort_order' => 1,
                        'ar' => ['title' => 'سرعة الانطلاق', 'description' => '⚡ خلال 48 ساعة'],
                        'en' => ['title' => 'Launch Speed', 'description' => '⚡ Within 48 hours'],
                    ],
                    [
                        'sort_order' => 2,
                        'ar' => ['title' => 'التكامل مع الأنظمة', 'description' => '🔗 مباشر على أنظمتك (Plug & Play)'],
                        'en' => ['title' => 'System Integration', 'description' => '🔗 Direct on your systems (Plug & Play)'],
                    ],
                    [
                        'sort_order' => 3,
                        'ar' => ['title' => 'تكاليف الإعداد', 'description' => '💚 صفر ريال'],
                        'en' => ['title' => 'Setup Costs', 'description' => '💚 Zero cost'],
                    ],
                    [
                        'sort_order' => 4,
                        'ar' => ['title' => 'قابلية التوسع', 'description' => '📈 مرونة كاملة وزيادة فورية'],
                        'en' => ['title' => 'Scalability', 'description' => '📈 Full flexibility and instant scaling'],
                    ],
                ],
            ],
            [
                'ar' => ['title' => 'التعهيد التقليدي', 'subtitle' => 'Outsourcing'],
                'en' => ['title' => 'Traditional Outsourcing', 'subtitle' => 'Outsourcing'],
                'is_featured' => false,
                'sort_order' => 2,
                'features' => [
                    [
                        'sort_order' => 1,
                        'ar' => ['title' => 'سرعة الانطلاق', 'description' => '⏳ 3 - 6 أسابيع'],
                        'en' => ['title' => 'Launch Speed', 'description' => '⏳ 3 - 6 weeks'],
                    ],
                    [
                        'sort_order' => 2,
                        'ar' => ['title' => 'التكامل مع الأنظمة', 'description' => '❌ يتطلب نقل بيانات وأنظمة جديدة'],
                        'en' => ['title' => 'System Integration', 'description' => '❌ Requires data migration and new systems'],
                    ],
                    [
                        'sort_order' => 3,
                        'ar' => ['title' => 'تكاليف الإعداد', 'description' => '💸 رسوم تأسيس عالية'],
                        'en' => ['title' => 'Setup Costs', 'description' => '💸 High setup fees'],
                    ],
                    [
                        'sort_order' => 4,
                        'ar' => ['title' => 'قابلية التوسع', 'description' => '📉 عقود جامدة وشروط معقدة'],
                        'en' => ['title' => 'Scalability', 'description' => '📉 Rigid contracts and complex terms'],
                    ],
                ],
            ],
            [
                'ar' => ['title' => 'التوظيف الداخلي', 'subtitle' => 'In-house Team'],
                'en' => ['title' => 'In-house Team', 'subtitle' => 'In-house Team'],
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [
                    [
                        'sort_order' => 1,
                        'ar' => ['title' => 'سرعة الانطلاق', 'description' => '⏳ 1 - 2 شهر'],
                        'en' => ['title' => 'Launch Speed', 'description' => '⏳ 1 - 2 months'],
                    ],
                    [
                        'sort_order' => 2,
                        'ar' => ['title' => 'التكامل مع الأنظمة', 'description' => '⚠️ مكلف ويحتاج إعداد طويل'],
                        'en' => ['title' => 'System Integration', 'description' => '⚠️ Costly and requires long setup'],
                    ],
                    [
                        'sort_order' => 3,
                        'ar' => ['title' => 'تكاليف الإعداد', 'description' => '💸 استقطاب وتدريب وتجهيز'],
                        'en' => ['title' => 'Setup Costs', 'description' => '💸 Recruitment, training and equipment'],
                    ],
                    [
                        'sort_order' => 4,
                        'ar' => ['title' => 'قابلية التوسع', 'description' => '❌ صعوبة في إعادة الهيكلة'],
                        'en' => ['title' => 'Scalability', 'description' => '❌ Difficult to restructure'],
                    ],
                ],
            ],
        ];

        foreach ($items as $itemData) {
            $features = $itemData['features'];

            $item = WhyChooseUs::updateOrCreate(
                ['sort_order' => $itemData['sort_order']],
                ['is_featured' => $itemData['is_featured']]
            );

            $item->translations()->updateOrCreate(['locale' => 'ar'], $itemData['ar']);
            $item->translations()->updateOrCreate(['locale' => 'en'], $itemData['en']);

            foreach ($features as $featureData) {
                $feature = WhyChooseUsFeature::updateOrCreate(
                    ['why_choose_us_id' => $item->id, 'sort_order' => $featureData['sort_order']]
                );

                $feature->translations()->updateOrCreate(['locale' => 'ar'], $featureData['ar']);
                $feature->translations()->updateOrCreate(['locale' => 'en'], $featureData['en']);
            }
        }
    }
}
