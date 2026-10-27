<?php

namespace Database\Seeders;

use App\Models\Sanad\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteBlogSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('blog_translations')->delete();
        DB::table('blogs')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $blogs = [
            [
                'is_featured' => true,
                'image' => null,
                'translations' => [
                    'ar' => [
                        'title' => 'مستقبل تجربة العملاء في السعودية 2026: الاتجاهات التي ستصنع الفرق',
                        'slug' => 'future-of-customer-experience-saudi-arabia-2026',
                        'description' => 'من الذكاء الاصطناعي إلى القنوات الموحدة؛ نستعرض أبرز التحولات التي تعيد تشكيل توقعات العملاء وكيف تستعد شركتك لها من الآن.',
                        'content' => '<p>يشهد قطاع تجربة العملاء في المملكة العربية السعودية تحولاً جذرياً مدفوعاً برؤية السعودية 2030، وتزايد تطلعات العملاء، وتسارع تبني التقنيات الحديثة. في عام 2026، لم يعد تقديم خدمة جيدة خياراً، بل أصبح ميزة تنافسية حاسمة.</p><h2>أبرز الاتجاهات</h2><h3>1. الذكاء الاصطناعي وروبوتات المحادثة الذكية</h3><p>أصبح الذكاء الاصطناعي قادراً على فهم اللهجات العربية السعودية والرد بشكل طبيعي، مما يتيح أتمتة الاستفسارات المتكررة دون المساس بجودة التجربة.</p><h3>2. تجربة omnichannel موحدة</h3><p>يتوقع العملاء الانتقال بسلاسة بين الهاتف، الواتساب، الموقع الإلكتروني، والتطبيق دون الحاجة لإعادة شرح المشكلة من جديد.</p><h3>3. التخصيص المبني على البيانات</h3><p>بفضل تحليل سلوك العملاء، يمكن للشركات تقديم حلول مخصصة وتوصيات ذات صلة في الوقت المناسب.</p><h2>كيف تستعد شركتك؟</h2><p>الاستثمار في البنية التحتية الرقمية، وتدريب الكوادر، واختيار شريك تشغيلي مناسب، كلها خطوات ضرورية للنجاح في هذا التحول.</p>',
                    ],
                    'en' => [
                        'title' => 'Future of Customer Experience in Saudi Arabia 2026: Trends That Will Make the Difference',
                        'slug' => 'future-of-customer-experience-saudi-arabia-2026-en',
                        'description' => 'From AI to unified channels; we explore the key shifts reshaping customer expectations and how your business can prepare now.',
                        'content' => '<p>Saudi Arabia\'s customer experience sector is undergoing a radical transformation driven by Vision 2030, rising customer expectations, and rapid technology adoption. In 2026, delivering good service is no longer optional—it\'s a critical competitive advantage.</p><h2>Key Trends</h2><h3>1. AI and Intelligent Chatbots</h3><p>AI can now understand Saudi Arabic dialects and respond naturally, enabling automation of repetitive inquiries without compromising experience quality.</p><h3>2. Unified Omnichannel Experience</h3><p>Customers expect seamless transitions between phone, WhatsApp, website, and app without repeating their issue.</p><h3>3. Data-Driven Personalization</h3><p>By analyzing customer behavior, businesses can deliver personalized solutions and relevant recommendations at the right time.</p><h2>How to Prepare</h2><p>Investing in digital infrastructure, training teams, and choosing the right outsourcing partner are all essential steps for success.</p>',
                    ],
                ],
            ],
            [
                'is_featured' => false,
                'image' => null,
                'translations' => [
                    'ar' => [
                        'title' => 'كيف تقلل وقت الاستجابة لعملائك إلى أقل من 60 ثانية',
                        'slug' => 'how-to-reduce-customer-response-time-to-under-60-seconds',
                        'description' => 'خطوات عملية لتنظيم قنوات الدعم وتوزيع المحادثات بذكاء، بما يرفع رضا العملاء ويخفض معدلات التخلي عن المكالمات.',
                        'content' => '<p>وقت الاستجابة هو أحد أهم مؤشرات تجربة العملاء. كل ثانية إضافية تزيد من إحباط العميل وفرصة فقدانه.</p><h2>خطوات عملية</h2><ul><li><strong>توحيد القنوات:</strong> دمج جميع قنوات التواصل في لوحة واحدة</li><li><strong>التوزيع الذكي:</strong> استخدام توجيه تلقائي حسب الخبرة والتوفر</li><li><strong>أتمتة الردود السريعة:</strong> للأسئلة المتكررة</li><li><strong>متابعة الأداء:</strong> مراقبة متوسط وقت الرد لحظياً</li><li><strong>فريق مدرب جيداً:</strong> مع أدلة رد واضحة</li></ul>',
                    ],
                    'en' => [
                        'title' => 'How to Reduce Customer Response Time to Under 60 Seconds',
                        'slug' => 'how-to-reduce-customer-response-time-to-under-60-seconds-en',
                        'description' => 'Practical steps to organize support channels and intelligently distribute conversations to boost satisfaction and reduce call abandonment.',
                        'content' => '<p>Response time is one of the most critical customer experience metrics. Every extra second increases frustration and the risk of losing customers.</p><h2>Practical Steps</h2><ul><li><strong>Unify channels:</strong> Consolidate all communication channels into one dashboard</li><li><strong>Smart routing:</strong> Use automatic routing based on expertise and availability</li><li><strong>Quick response automation:</strong> For frequently asked questions</li><li><strong>Monitor performance:</strong> Track average response time in real-time</li><li><strong>Well-trained team:</strong> With clear response guidelines</li></ul>',
                    ],
                ],
            ],
            [
                'is_featured' => false,
                'image' => null,
                'translations' => [
                    'ar' => [
                        'title' => 'التعهيد أم التوظيف الداخلي؟ مقارنة واقعية لتكلفة مراكز الاتصال',
                        'slug' => 'outsourcing-vs-inhouse-call-center-cost-comparison',
                        'description' => 'نحسب معاً التكلفة الحقيقية لكل نموذج تشغيلي، من الرواتب والتدريب إلى البنية التحتية وساعات العمل الضائعة.',
                        'content' => '<p>عندما تقرر إنشاء مركز اتصال, يبرز سؤال حاسم: هل نوظف داخلياً أم نعهد للتشغيل الخارجي؟</p><h2>مقارنة التكاليف</h2><p>التوظيف الداخلي يتطلب رواتب، تأمينات، تدريب، مساحات مكتبية، معدات، أنظمة، وإدارة. أما التعهيد فيوفر مرونة أكبر بتكلفة متوقعة غالباً أقل.</p><h2>عوامل أخرى يجب مراعاتها</h2><ul><li>المرونة في الحجم حسب الموسم</li><li>سرعة التشغيل</li><li>التركيز على الأعمال الأساسية</li><li>ضمان الجودة والامتثال</li></ul>',
                    ],
                    'en' => [
                        'title' => 'Outsourcing vs In-House: A Realistic Comparison of Call Center Costs',
                        'slug' => 'outsourcing-vs-inhouse-call-center-cost-comparison-en',
                        'description' => 'We calculate the true cost of each operating model, from salaries and training to infrastructure and wasted hours.',
                        'content' => '<p>When deciding to establish a call center, a critical question arises: hire in-house or outsource operations?</p><h2>Cost Comparison</h2><p>In-house requires salaries, benefits, training, office space, equipment, systems, and management. Outsourcing offers greater flexibility at a more predictable and often lower cost.</p><h2>Other Factors to Consider</h2><ul><li>Scalability by season</li><li>Speed to launch</li><li>Focus on core business</li><li>Quality assurance and compliance</li></ul>',
                    ],
                ],
            ],
        ];

        foreach ($blogs as $item) {
            $blog = Blog::create([
                'image' => $item['image'],
                'is_featured' => $item['is_featured'],
            ]);

            foreach ($item['translations'] as $locale => $trans) {
                $blog->translations()->create(array_merge($trans, ['locale' => $locale]));
            }
        }
    }
}
