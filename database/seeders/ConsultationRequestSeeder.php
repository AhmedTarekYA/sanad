<?php

namespace Database\Seeders;

use App\Models\Sanad\ConsultationRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ConsultationRequestSeeder extends Seeder
{
    /**
     * Realistic Saudi consultation requests for demo purposes.
     *
     * @var array<int, array<string, mixed>>
     */
    private array $requests = [
        [
            'full_name' => 'عبدالله محمد القحطاني',
            'company_name' => 'شركة الأفق للتجارة',
            'mobile_whatsapp' => '+966501234567',
            'daily_contact_volume' => '50 - 200 تواصل',
            'current_systems' => 'Zendesk',
            'is_read' => true,
            'days_ago' => 1,
        ],
        [
            'full_name' => 'محمد سعد الحربي',
            'company_name' => 'مؤسسة النخيل الذهبي',
            'mobile_whatsapp' => '+966553987641',
            'daily_contact_volume' => 'أقل من 50 تواصل',
            'current_systems' => 'WhatsApp Business + Excel',
            'is_read' => false,
            'days_ago' => 1,
        ],
        [
            'full_name' => 'فيصل عبدالعزيز العتيبي',
            'company_name' => 'تموين السعودية',
            'mobile_whatsapp' => '+966559876543',
            'daily_contact_volume' => '200 - 500 تواصل',
            'current_systems' => 'Freshdesk',
            'is_read' => false,
            'days_ago' => 2,
        ],
        [
            'full_name' => 'سعود ناصر الدوسري',
            'company_name' => 'مجموعة رواد الأعمال',
            'mobile_whatsapp' => '+966544445566',
            'daily_contact_volume' => 'أكثر من 500 تواصل',
            'current_systems' => 'Salesforce',
            'is_read' => true,
            'days_ago' => 3,
        ],
        [
            'full_name' => 'خالد فهد الشمري',
            'company_name' => 'شركة المسار التقني',
            'mobile_whatsapp' => '+966566778899',
            'daily_contact_volume' => '50 - 200 تواصل',
            'current_systems' => 'Odoo',
            'is_read' => false,
            'days_ago' => 4,
        ],
        [
            'full_name' => 'تركي بندر المطيري',
            'company_name' => 'متجر دار الأناقة',
            'mobile_whatsapp' => '+966580112233',
            'daily_contact_volume' => 'أقل من 50 تواصل',
            'current_systems' => 'منصة سلة + واتساب',
            'is_read' => true,
            'days_ago' => 5,
        ],
        [
            'full_name' => 'سلطان ماجد الغامدي',
            'company_name' => 'شركة بيادر الغذاء',
            'mobile_whatsapp' => '+966591234987',
            'daily_contact_volume' => '200 - 500 تواصل',
            'current_systems' => 'Talkdesk',
            'is_read' => false,
            'days_ago' => 6,
        ],
        [
            'full_name' => 'نواف سعيد الزهراني',
            'company_name' => 'مؤسسة سدرة للتجزئة',
            'mobile_whatsapp' => '+966500667788',
            'daily_contact_volume' => '50 - 200 تواصل',
            'current_systems' => 'لا يوجد',
            'is_read' => true,
            'days_ago' => 8,
        ],
        [
            'full_name' => 'عبدالعزيز علي الشهري',
            'company_name' => 'شركة وصل للخدمات اللوجستية',
            'mobile_whatsapp' => '+966531119988',
            'daily_contact_volume' => 'أكثر من 500 تواصل',
            'current_systems' => 'Zoho Desk',
            'is_read' => false,
            'days_ago' => 10,
        ],
        [
            'full_name' => 'فهد حمد المالكي',
            'company_name' => 'مجموعة الفيصلية الطبية',
            'mobile_whatsapp' => '+966552224466',
            'daily_contact_volume' => '200 - 500 تواصل',
            'current_systems' => 'نظام CRM داخلي',
            'is_read' => true,
            'days_ago' => 12,
        ],
        [
            'full_name' => 'ماجد عبدالله العنزي',
            'company_name' => 'شركة ارتقاء للاستشارات',
            'mobile_whatsapp' => '+966569887766',
            'daily_contact_volume' => 'أقل من 50 تواصل',
            'current_systems' => null,
            'is_read' => false,
            'days_ago' => 15,
        ],
        [
            'full_name' => 'بندر خالد السبيعي',
            'company_name' => 'متجر لمسة بيت',
            'mobile_whatsapp' => '+966502345678',
            'daily_contact_volume' => '50 - 200 تواصل',
            'current_systems' => 'Google Sheets + واتساب',
            'is_read' => true,
            'days_ago' => 18,
        ],
        [
            'full_name' => 'ناصر عبدالرحمن الرشيدي',
            'company_name' => 'شركة أعمال الخليج للمقاولات',
            'mobile_whatsapp' => '+966547778899',
            'daily_contact_volume' => '200 - 500 تواصل',
            'current_systems' => 'Freshdesk',
            'is_read' => true,
            'days_ago' => 21,
        ],
        [
            'full_name' => 'يوسف صالح العمري',
            'company_name' => 'مؤسسة أضواء المدينة',
            'mobile_whatsapp' => '+966589001122',
            'daily_contact_volume' => 'أكثر من 500 تواصل',
            'current_systems' => 'Zendesk + واتساب',
            'is_read' => false,
            'days_ago' => 24,
        ],
        [
            'full_name' => 'إبراهيم عادل اليامي',
            'company_name' => 'شركة ركاز العقارية',
            'mobile_whatsapp' => '+966555443322',
            'daily_contact_volume' => 'أقل من 50 تواصل',
            'current_systems' => null,
            'is_read' => true,
            'days_ago' => 28,
        ],
    ];

    public function run(): void
    {
        foreach ($this->requests as $request) {
            $daysAgo = $request['days_ago'];
            $timestamp = Carbon::now()->subDays($daysAgo)->setTime(random_int(9, 20), random_int(0, 59));

            $consultation = ConsultationRequest::updateOrCreate(
                ['mobile_whatsapp' => $request['mobile_whatsapp']],
                [
                    'full_name' => $request['full_name'],
                    'company_name' => $request['company_name'],
                    'daily_contact_volume' => $request['daily_contact_volume'],
                    'current_systems' => $request['current_systems'],
                    'is_read' => $request['is_read'],
                ]
            );

            $consultation->forceFill([
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ])->save();
        }

        $this->command->info('Consultation requests seeded: '.count($this->requests));
    }
}
