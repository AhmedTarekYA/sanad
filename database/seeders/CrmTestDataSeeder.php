<?php

namespace Database\Seeders;

use App\Models\CRM\CrmContactNote;
use App\Models\CRM\CrmSale;
use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappBusinessSetting;
use App\Models\CRM\WhatsappContact;
use App\Models\CRM\WhatsappConversation;
use App\Models\CRM\WhatsappMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CrmTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = CrmUser::updateOrCreate(
            ['email' => 'admin@crm.test'],
            [
                'name' => 'Admin CRM',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'permissions' => null,
                'is_active' => true,
                'subscription_ends_at' => now()->addYear(),
            ]
        );

        $agent = CrmUser::updateOrCreate(
            ['email' => 'agent@crm.test'],
            [
                'name' => 'Agent Test',
                'password' => Hash::make('password'),
                'role' => 'agent',
                'permissions' => ['whatsapp_chat', 'whatsapp_contacts', 'crm_sales'],
                'is_active' => true,
                'subscription_ends_at' => now()->addYear(),
            ]
        );

        $business = WhatsappBusinessSetting::firstOrCreate(
            ['crm_user_id' => $admin->id, 'name' => 'CRM Test Business'],
            [
                'is_active' => true,
                'api_version' => 'v20.0',
                'phone_number_id' => '100000000000001',
                'business_account_id' => '200000000000001',
            ]
        );

        $contactsData = [
            ['wa_id' => '966500000001', 'name' => 'أحمد العتيبي'],
            ['wa_id' => '966500000002', 'name' => 'سارة الحربي'],
            ['wa_id' => '966500000003', 'name' => 'محمد القحطاني'],
            ['wa_id' => '966500000004', 'name' => 'نورة الشمري'],
            ['wa_id' => '966500000005', 'name' => 'خالد السبيعي'],
        ];

        $contacts = collect($contactsData)->map(function (array $contact) use ($admin): WhatsappContact {
            return WhatsappContact::firstOrCreate(
                ['crm_user_id' => $admin->id, 'wa_id' => $contact['wa_id']],
                [
                    'name' => $contact['name'],
                    'source' => 'seed',
                    'registered_at' => now(),
                    'last_activity' => now(),
                ]
            );
        });

        $statuses = ['open', 'resolved', 'open'];
        $conversations = $contacts->take(3)->values()->map(function (WhatsappContact $contact, int $index) use ($admin, $business, $statuses): WhatsappConversation {
            return WhatsappConversation::firstOrCreate(
                [
                    'crm_user_id' => $admin->id,
                    'wa_id' => $contact->wa_id,
                    'whatsapp_business_setting_id' => $business->id,
                ],
                [
                    'display_name' => $contact->name,
                    'status' => $statuses[$index],
                    'resolved_at' => $statuses[$index] === 'resolved' ? now() : null,
                    'last_message_at' => now(),
                    'unread_count' => $index === 0 ? 2 : 0,
                ]
            );
        });

        $messagesData = [
            ['direction' => 'inbound', 'body' => 'السلام عليكم، أرغب بالاستفسار عن المنتجات'],
            ['direction' => 'outbound', 'body' => 'وعليكم السلام، أهلاً بك. كيف يمكننا مساعدتك؟'],
            ['direction' => 'inbound', 'body' => 'هل متوفر لديكم الشحن إلى الرياض؟'],
            ['direction' => 'outbound', 'body' => 'نعم، الشحن متوفر لجميع مدن المملكة.'],
            ['direction' => 'inbound', 'body' => 'ممتاز، أريد الطلب'],
            ['direction' => 'outbound', 'body' => 'تم استلام طلبك، سيتم التواصل معك قريباً.'],
            ['direction' => 'inbound', 'body' => 'شكراً جزيلاً'],
            ['direction' => 'inbound', 'body' => 'مرحباً، لدي استفسار عن الأسعار'],
            ['direction' => 'outbound', 'body' => 'أهلاً بك، تم إرسال قائمة الأسعار لك.'],
            ['direction' => 'inbound', 'body' => 'تم الاستلام، شكراً'],
            ['direction' => 'outbound', 'body' => 'بخدمتك دائماً.'],
            ['direction' => 'inbound', 'body' => 'هل يوجد خصم على الكميات الكبيرة؟'],
        ];

        foreach ($messagesData as $index => $message) {
            $conversation = $conversations[$index % $conversations->count()];
            $contact = $contacts->firstWhere('wa_id', $conversation->wa_id);

            WhatsappMessage::firstOrCreate(
                ['wamid' => 'seed-msg-'.$index],
                [
                    'conversation_id' => $conversation->id,
                    'crm_user_id' => $admin->id,
                    'whatsapp_business_setting_id' => $business->id,
                    'direction' => $message['direction'],
                    'from_wa_id' => $message['direction'] === 'inbound' ? $conversation->wa_id : '100000000000001',
                    'to_wa_id' => $message['direction'] === 'inbound' ? '100000000000001' : $conversation->wa_id,
                    'type' => 'text',
                    'message_status' => $message['direction'] === 'outbound' ? 'sent' : null,
                    'body' => $message['body'],
                    'wa_timestamp' => now()->subMinutes(30 - $index),
                    'raw' => ['seeded' => true, 'contact' => $contact?->name],
                ]
            );
        }

        $salesData = [
            ['crm_user_id' => $admin->id, 'customer_name' => 'أحمد العتيبي', 'phone' => '966500000001', 'request_text' => 'طلب باقة أعمال متكاملة', 'price' => 1500.00],
            ['crm_user_id' => $agent->id, 'customer_name' => 'سارة الحربي', 'phone' => '966500000002', 'request_text' => 'استفسار عن خدمة الدعم الشهري', 'price' => 800.00],
            ['crm_user_id' => $agent->id, 'customer_name' => 'محمد القحطاني', 'phone' => '966500000003', 'request_text' => 'طلب تطوير متجر إلكتروني', 'price' => 3200.00],
        ];

        foreach ($salesData as $sale) {
            CrmSale::firstOrCreate(
                ['crm_user_id' => $sale['crm_user_id'], 'phone' => $sale['phone'], 'customer_name' => $sale['customer_name']],
                $sale
            );
        }

        $thirdConversation = $conversations->get(2) ?? $conversations->last();
        if ($thirdConversation) {
            $richMessages = [
                [
                    'wamid' => 'seed-rich-1',
                    'type' => 'image',
                    'direction' => 'outbound',
                    'body' => 'تفضل هنا صورة المنتج الجديد 🖼️',
                    'raw' => ['seeded' => true, 'local_public_path' => 'admin/assets/img/whats.png'],
                ],
                [
                    'wamid' => 'seed-rich-2',
                    'type' => 'image',
                    'direction' => 'inbound',
                    'body' => 'شكراً، كيف يمكنني الطلب؟',
                    'raw' => ['seeded' => true, 'local_public_path' => 'admin/assets/img/think.png'],
                ],
                [
                    'wamid' => 'seed-rich-3',
                    'type' => 'video',
                    'direction' => 'outbound',
                    'body' => 'هنا فيديو شرح المنتج 🎥',
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-4',
                    'type' => 'audio',
                    'direction' => 'inbound',
                    'body' => null,
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-5',
                    'type' => 'text',
                    'direction' => 'outbound',
                    'body' => 'أهلاً! سيتم التواصل معك من فريق المبيعات خلال 24 ساعة. 🚀',
                    'raw' => ['seeded' => true],
                ],
            ];

            foreach ($richMessages as $i => $rm) {
                WhatsappMessage::firstOrCreate(
                    ['wamid' => $rm['wamid']],
                    [
                        'conversation_id' => $thirdConversation->id,
                        'crm_user_id' => $agent->id,
                        'whatsapp_business_setting_id' => $business->id,
                        'direction' => $rm['direction'],
                        'from_wa_id' => $rm['direction'] === 'inbound' ? $thirdConversation->wa_id : '100000000000001',
                        'to_wa_id' => $rm['direction'] === 'inbound' ? '100000000000001' : $thirdConversation->wa_id,
                        'type' => $rm['type'],
                        'message_status' => $rm['direction'] === 'outbound' ? 'sent' : null,
                        'body' => $rm['body'],
                        'wa_timestamp' => now()->subMinutes(10 - $i),
                        'raw' => $rm['raw'],
                    ]
                );
            }
        }

        $firstContact = $contacts->first();
        if ($firstContact) {
            CrmContactNote::firstOrCreate(
                ['whatsapp_contact_id' => $firstContact->id, 'crm_user_id' => $agent->id],
                ['note' => 'عميل بيستفسر كتير ومش بيشتري — يحتاج متابعة خاصة قبل أي عرض.']
            );
        }
    }
}
