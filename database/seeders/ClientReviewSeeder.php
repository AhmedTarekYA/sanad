<?php

namespace Database\Seeders;

use App\Models\Sanad\ClientReview;
use Illuminate\Database\Seeder;

class ClientReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'ar' => [
                    'name' => 'م. خالد القحطاني',
                    'job' => 'الرئيس التنفيذي',
                    'company_name' => 'شركة حلول واستشارات B2B',
                    'review_message' => 'أكبر تحدي كان عندنا هو ضبط التكاليف التشغيلية للاتصالات ودعم العملاء. فريق Sanad CX اشتغل مباشرة على سيستم السنترال والـ CRM الخاص بنا بنفس معايير الحوكمة والسرية، ونجحنا في خفض المصاريف التشغيلية بأكثر من 35% مع رفع كفاءة الجودة.',
                ],
                'en' => [
                    'name' => 'Eng. Khalid Al-Qahtani',
                    'job' => 'Chief Executive Officer',
                    'company_name' => 'B2B Solutions & Consulting Firm',
                    'review_message' => 'Our biggest challenge was controlling operational costs for communications and customer support. The Sanad CX team worked directly on our PBX and CRM systems with the same governance and confidentiality standards, and we managed to reduce operational expenses by more than 35% while improving quality.',
                ],
            ],
            [
                'ar' => [
                    'name' => 'أ. فهد السبيعي',
                    'job' => 'مدير العمليات',
                    'company_name' => 'متجر تجزئة رائد بالرياض',
                    'review_message' => 'المرونة وسرعة الاستجابة عندهم فرقت معانا بشكل ملموس. قدرنا نغطي السلات المتروكة واستفسارات الواتساب على مدار 24 ساعة بدون ما نتحمل أي تكاليف تأسيس أو تعقيدات توظيف. النتيجة كانت زيادة في المبيعات وتجربة عميل مختلفة تماماً عن السوق.',
                ],
                'en' => [
                    'name' => 'Mr. Fahad Al-Subaie',
                    'job' => 'Operations Manager',
                    'company_name' => 'Leading Retail Store in Riyadh',
                    'review_message' => 'Their flexibility and speed of response made a tangible difference for us. We were able to cover abandoned carts and WhatsApp inquiries around the clock without bearing any setup costs or hiring complexities. The result was increased sales and a customer experience completely different from the market.',
                ],
            ],
            [
                'ar' => [
                    'name' => 'د. معاذ الشمري',
                    'job' => 'المدير التنفيذي للتشغيل',
                    'company_name' => 'مجموعة مراكز طبية',
                    'review_message' => 'التعاون مع Sanad CX لم يكن مجرد إسناد كول سنتر، بل شراكة استراتيجية حقيقية. استيعابهم السريع لطبيعة خدماتنا الطبية ودقة متابعة طلبات العملاء أتاح لنا التوسع في مناطق جديدة بالرياض بثقة وبدون الحاجة لزيادة الهيكل الإداري.',
                ],
                'en' => [
                    'name' => 'Dr. Muadh Al-Shammari',
                    'job' => 'Executive Director of Operations',
                    'company_name' => 'Medical Centers Group',
                    'review_message' => 'Working with Sanad CX was not just a call center outsourcing, but a true strategic partnership. Their quick understanding of our medical services and precise follow-up on customer requests allowed us to expand to new areas in Riyadh with confidence and without needing to grow our administrative structure.',
                ],
            ],
            [
                'ar' => [
                    'name' => 'أ. عبدالأول الغامدي',
                    'job' => 'مدير نمو المبيعات (Head of Growth)',
                    'company_name' => 'منصة SaaS رقمية',
                    'review_message' => 'احترافية فريق المبيعات الهاتفي ودرايتهم بسلوك المستهلك السعودي ساهمت في رفع معدل إغلاق الصفقات وتحويل العملاء المحتملين بنسبة 40% خلال أول 90 يوم عمل متواصل. التكامل والسرعة عندهم شي يُشكرون عليه.',
                ],
                'en' => [
                    'name' => 'Mr. Abdulawwal Al-Ghamdi',
                    'job' => 'Head of Growth',
                    'company_name' => 'Digital SaaS Platform',
                    'review_message' => "The professionalism of the telesales team and their knowledge of Saudi consumer behavior contributed to raising the deal closing rate and converting prospects by 40% within the first 90 continuous working days. Their integration speed is truly commendable.",
                ],
            ],
            [
                'ar' => [
                    'name' => 'أ. سلمان الدوسري',
                    'job' => 'مدير تجربة العملاء (CX Director)',
                    'company_name' => 'شركة لوجستيات وسلاسل إمداد',
                    'review_message' => 'ما يميز Sanad CX هو الثبات والجودة العالية حتى في مواسم الضغط العالي. سهولة الربط المباشر على أنظمتنا الحالية مع متابعة الـ KPIs بدقة جعلتنا نعتمد عليهم كشريك دائم ومستمر لجميع خدمات تجربة العملاء.',
                ],
                'en' => [
                    'name' => 'Mr. Salman Al-Dosari',
                    'job' => 'CX Director',
                    'company_name' => 'Logistics & Supply Chain Company',
                    'review_message' => 'What sets Sanad CX apart is their consistency and high quality even during peak seasons. The ease of direct integration with our existing systems combined with precise KPI tracking has made us rely on them as a permanent and ongoing partner for all customer experience services.',
                ],
            ],
        ];

        foreach ($reviews as $data) {
            $existing = ClientReview::whereHas(
                'translations',
                fn ($q) => $q->where('locale', 'ar')->where('name', $data['ar']['name'])
            )->first();

            $review = $existing ?? ClientReview::create();

            $review->translations()->updateOrCreate(['locale' => 'ar'], $data['ar']);
            $review->translations()->updateOrCreate(['locale' => 'en'], $data['en']);
        }
    }
}
