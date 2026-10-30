<?php

namespace Database\Seeders;

use App\Models\Sanad\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'sort_order' => 1,
                'ar' => [
                    'question' => 'هل نحتاج إلى تغيير السنترال أو نظام الواتساب الحالي لدينا؟',
                    'answer' => 'لا على الإطلاق. يتكامل فريق سند مع أنظمتك الحالية — سواء كان سنترالاً مادياً أو سحابياً أو واتساب بزنس — دون الحاجة إلى تغيير أي بنية تحتية.',
                ],
                'en' => [
                    'question' => 'Do we need to change our current PBX or WhatsApp system?',
                    'answer' => 'Not at all. The Sanad team integrates with your existing systems — whether a physical or cloud PBX, or WhatsApp Business — without requiring any infrastructure changes.',
                ],
            ],
            [
                'sort_order' => 2,
                'ar' => [
                    'question' => 'كيف تضمنون جودة الردود وإلمام الفريق بمنتجاتنا وخدماتنا؟',
                    'answer' => 'نبدأ بجلسة تأهيل مكثفة نتعرف فيها على منتجاتك وخدماتك وأسلوب تواصلك. بعدها يُشرف مشرف جودة مخصص على المكالمات ويقدم تقارير دورية وجلسات تدريبية مستمرة لضمان أعلى مستوى من الاتساق.',
                ],
                'en' => [
                    'question' => 'How do you ensure response quality and team familiarity with our products and services?',
                    'answer' => 'We start with an intensive onboarding session to learn about your products, services, and communication style. A dedicated quality supervisor then monitors calls, delivers periodic reports, and runs ongoing training sessions to ensure maximum consistency.',
                ],
            ],
            [
                'sort_order' => 3,
                'ar' => [
                    'question' => 'هل توجد رسوم إعداد أو حد أدنى للتعاقد؟',
                    'answer' => 'لا توجد رسوم إعداد خفية. يمكن البدء بعقد شهري مرن مع حرية التوسع أو التقليص وفقاً لاحتياجاتك. نؤمن بأن تجربة سند يجب أن تكون في متناول كل شركة.',
                ],
                'en' => [
                    'question' => 'Are there setup fees or a minimum contract period?',
                    'answer' => 'There are no hidden setup fees. You can start with a flexible monthly contract, with the freedom to scale up or down based on your needs. We believe the Sanad experience should be accessible to every business.',
                ],
            ],
            [
                'sort_order' => 4,
                'ar' => [
                    'question' => 'كم يستغرق وقت الإطلاق والبدء بالعمل الفعلي؟',
                    'answer' => 'نستطيع الانطلاق خلال 48 ساعة من توقيع العقد وإتمام جلسة التأهيل. سرعة الانطلاق ميزة أساسية تميزنا عن توظيف فريق داخلي يحتاج أسابيع أو أشهر.',
                ],
                'en' => [
                    'question' => 'How long does it take to go live?',
                    'answer' => 'We can go live within 48 hours of signing the contract and completing the onboarding session. Fast launch is a core advantage that sets us apart from hiring an in-house team, which takes weeks or months.',
                ],
            ],
            [
                'sort_order' => 5,
                'ar' => [
                    'question' => 'هل يمكن التعامل مع أحجام تواصل كبيرة في أوقات الذروة؟',
                    'answer' => 'نعم. نوفر طاقة استيعابية مرنة تتناسب مع حجم تواصلك — سواء كنت تستقبل عشرات أو مئات المكالمات يومياً. يمكن زيادة حجم الفريق في أوقات الذروة أو المناسبات الموسمية بسرعة ودون تكاليف إضافية مرتفعة.',
                ],
                'en' => [
                    'question' => 'Can you handle high volumes of interactions during peak periods?',
                    'answer' => 'Yes. We provide flexible capacity that scales with your contact volume — whether you receive tens or hundreds of calls daily. Team size can be increased quickly during peak periods or seasonal events without significant additional costs.',
                ],
            ],
            [
                'sort_order' => 6,
                'ar' => [
                    'question' => 'كيف تحمون بيانات عملائنا؟',
                    'answer' => 'يوقّع فريق سند على اتفاقية عدم إفصاح (NDA) رسمية قبل بدء العمل. نلتزم بأعلى معايير السرية والأمان في التعامل مع بيانات عملائك، وجميع الأنظمة المستخدمة تعمل ضمن بيئات آمنة ومغلقة.',
                ],
                'en' => [
                    'question' => 'How do you protect our customer data?',
                    'answer' => 'The Sanad team signs a formal Non-Disclosure Agreement (NDA) before work begins. We adhere to the highest confidentiality and security standards when handling your customer data, and all systems used operate within secure, closed environments.',
                ],
            ],
        ];

        foreach ($faqs as $faqData) {
            $faq = Faq::updateOrCreate(
                ['sort_order' => $faqData['sort_order']],
                ['is_active' => true]
            );

            $faq->translations()->updateOrCreate(['locale' => 'ar'], $faqData['ar']);
            $faq->translations()->updateOrCreate(['locale' => 'en'], $faqData['en']);
        }
    }
}
