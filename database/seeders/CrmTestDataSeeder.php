<?php

namespace Database\Seeders;

use App\Models\CRM\CrmContactNote;
use App\Models\CRM\CrmSale;
use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappBroadcast;
use App\Models\CRM\WhatsappBusinessHoursSetting;
use App\Models\CRM\WhatsappBusinessSetting;
use App\Models\CRM\WhatsappChatTag;
use App\Models\CRM\WhatsappContact;
use App\Models\CRM\WhatsappConversation;
use App\Models\CRM\WhatsappMessage;
use App\Models\CRM\WhatsappQuickReply;
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
            ['wa_id' => '966500000006', 'name' => 'عبدالله الدوسري'],
            ['wa_id' => '966500000007', 'name' => 'ريم الغامدي'],
            ['wa_id' => '966500000008', 'name' => 'فهد العنزي'],
            ['wa_id' => '966500000009', 'name' => 'لمى المطيري'],
            ['wa_id' => '966500000010', 'name' => 'سلطان البقمي'],
            ['wa_id' => '966500000011', 'name' => 'هند الزهراني'],
            ['wa_id' => '966500000012', 'name' => 'ماجد الشهري'],
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

        $extraConversations = $contacts->slice(3)->values()->map(function (WhatsappContact $contact, int $index) use ($admin, $business): WhatsappConversation {
            $status = $index % 2 === 0 ? 'open' : 'resolved';

            return WhatsappConversation::firstOrCreate(
                [
                    'crm_user_id' => $admin->id,
                    'wa_id' => $contact->wa_id,
                    'whatsapp_business_setting_id' => $business->id,
                ],
                [
                    'display_name' => $contact->name,
                    'status' => $status,
                    'resolved_at' => $status === 'resolved' ? now() : null,
                    'last_message_at' => now(),
                    'unread_count' => $index % 3,
                ]
            );
        });

        $extraTexts = [
            'السلام عليكم، لدي استفسار بسيط',
            'أهلاً بك، تفضل كيف يمكننا مساعدتك؟',
            'أريد معرفة تفاصيل العرض الحالي',
            'بالتأكيد، سأرسل لك التفاصيل الآن.',
            'شكراً لك، سأنتظر ردك.',
        ];

        foreach ($extraConversations as $conversationIndex => $conversation) {
            $messageCount = 3 + ($conversationIndex % 3);

            for ($i = 0; $i < $messageCount; $i++) {
                $direction = $i % 2 === 0 ? 'inbound' : 'outbound';

                WhatsappMessage::firstOrCreate(
                    ['wamid' => 'seed-extra-'.$conversation->id.'-'.$i],
                    [
                        'conversation_id' => $conversation->id,
                        'crm_user_id' => $admin->id,
                        'whatsapp_business_setting_id' => $business->id,
                        'direction' => $direction,
                        'from_wa_id' => $direction === 'inbound' ? $conversation->wa_id : '100000000000001',
                        'to_wa_id' => $direction === 'inbound' ? '100000000000001' : $conversation->wa_id,
                        'type' => 'text',
                        'message_status' => $direction === 'outbound' ? 'sent' : null,
                        'body' => $extraTexts[$i % count($extraTexts)],
                        'wa_timestamp' => now()->subMinutes(15 - $i),
                        'raw' => ['seeded' => true, 'contact' => $conversation->display_name],
                    ]
                );
            }
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
            WhatsappMessage::where('conversation_id', $thirdConversation->id)
                ->where('raw->seeded', true)
                ->whereIn('wamid', array_map(fn ($n) => "seed-rich-{$n}", range(1, 10)))
                ->delete();

            $richMessages = [
                [
                    'wamid' => 'seed-rich-1',
                    'type' => 'text',
                    'direction' => 'inbound',
                    'body' => 'السلام عليكم، أريد الاستفسار عن المنتجات المتاحة عندكم',
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-2',
                    'type' => 'text',
                    'direction' => 'outbound',
                    'body' => 'وعليكم السلام! أهلاً وسهلاً، يسعدنا مساعدتك. ما الذي تبحث عنه تحديداً؟',
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-3',
                    'type' => 'image',
                    'direction' => 'outbound',
                    'body' => 'تفضل هذه صورة كتالوج منتجاتنا الجديدة 🖼️',
                    'raw' => ['seeded' => true, 'local_public_path' => 'admin/assets/img/whats.png'],
                ],
                [
                    'wamid' => 'seed-rich-4',
                    'type' => 'image',
                    'direction' => 'inbound',
                    'body' => 'ماشي، وهل لديكم هذا النوع؟',
                    'raw' => ['seeded' => true, 'local_public_path' => 'admin/assets/img/think.png'],
                ],
                [
                    'wamid' => 'seed-rich-5',
                    'type' => 'audio',
                    'direction' => 'inbound',
                    'body' => null,
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-6',
                    'type' => 'text',
                    'direction' => 'outbound',
                    'body' => 'استمعت للرسالة الصوتية، بالتأكيد لدينا ما تحتاجه! سأرسل لك فيديو توضيحي الآن.',
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-7',
                    'type' => 'video',
                    'direction' => 'outbound',
                    'body' => 'شاهد هذا الفيديو التوضيحي عن المنتج 🎥',
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-8',
                    'type' => 'audio',
                    'direction' => 'outbound',
                    'body' => null,
                    'raw' => ['seeded' => true],
                ],
                [
                    'wamid' => 'seed-rich-9',
                    'type' => 'image',
                    'direction' => 'inbound',
                    'body' => 'ممتاز! هل يمكنكم إرسال المنتج لهذا العنوان؟',
                    'raw' => ['seeded' => true, 'local_public_path' => 'admin/assets/img/whats.png'],
                ],
                [
                    'wamid' => 'seed-rich-10',
                    'type' => 'text',
                    'direction' => 'outbound',
                    'body' => 'أهلاً! سيتم التواصل معك من فريق المبيعات خلال 24 ساعة لتأكيد الطلب. 🚀',
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
                        'wa_timestamp' => now()->subMinutes(20 - $i * 2),
                        'raw' => $rm['raw'],
                    ]
                );
            }
        }

        foreach ($conversations->take(2)->values() as $richIndex => $conversation) {
            $richPrefix = 'seed-conv'.($richIndex + 1).'-rich';

            $richConversationMessages = [
                [
                    'index' => 1,
                    'type' => 'image',
                    'direction' => 'outbound',
                    'body' => 'تفضل صورة المنتج 🖼️',
                    'raw' => ['seeded' => true, 'local_public_path' => 'admin/assets/img/whats.png'],
                ],
                [
                    'index' => 2,
                    'type' => 'audio',
                    'direction' => 'inbound',
                    'body' => null,
                    'raw' => ['seeded' => true],
                ],
                [
                    'index' => 3,
                    'type' => 'video',
                    'direction' => 'outbound',
                    'body' => 'فيديو توضيحي',
                    'raw' => ['seeded' => true],
                ],
                [
                    'index' => 4,
                    'type' => 'text',
                    'direction' => 'inbound',
                    'body' => 'هل يمكنني الطلب الآن؟',
                    'raw' => ['seeded' => true],
                ],
                [
                    'index' => 5,
                    'type' => 'text',
                    'direction' => 'outbound',
                    'body' => 'بالتأكيد، سنساعدك في إتمام الطلب.',
                    'raw' => ['seeded' => true],
                ],
            ];

            foreach ($richConversationMessages as $richMessage) {
                WhatsappMessage::firstOrCreate(
                    ['wamid' => $richPrefix.'-'.$richMessage['index']],
                    [
                        'conversation_id' => $conversation->id,
                        'crm_user_id' => $admin->id,
                        'whatsapp_business_setting_id' => $business->id,
                        'direction' => $richMessage['direction'],
                        'from_wa_id' => $richMessage['direction'] === 'inbound' ? $conversation->wa_id : '100000000000001',
                        'to_wa_id' => $richMessage['direction'] === 'inbound' ? '100000000000001' : $conversation->wa_id,
                        'type' => $richMessage['type'],
                        'message_status' => $richMessage['direction'] === 'outbound' ? 'sent' : null,
                        'body' => $richMessage['body'],
                        'wa_timestamp' => now()->subMinutes(10 - $richMessage['index']),
                        'raw' => $richMessage['raw'],
                    ]
                );
            }
        }

        $quickRepliesData = [
            ['title' => 'ترحيب', 'shortcut' => '/hello', 'body' => 'أهلاً وسهلاً بك، كيف يمكننا مساعدتك اليوم؟'],
            ['title' => 'الأسعار', 'shortcut' => '/price', 'body' => 'يمكنك الاطلاع على قائمة الأسعار المرفقة، ولا تتردد بطلب أي توضيح.'],
            ['title' => 'شكر', 'shortcut' => '/thanks', 'body' => 'شكراً لتواصلك معنا، سعدنا بخدمتك.'],
            ['title' => 'الشحن', 'shortcut' => '/shipping', 'body' => 'الشحن متوفر لجميع مدن المملكة ويستغرق من 2 إلى 5 أيام عمل.'],
            ['title' => 'الدعم', 'shortcut' => '/support', 'body' => 'فريق الدعم جاهز لمساعدتك، يرجى إرسال تفاصيل المشكلة وسنرد عليك فوراً.'],
        ];

        foreach ($quickRepliesData as $quickReply) {
            WhatsappQuickReply::firstOrCreate(
                ['crm_user_id' => $admin->id, 'shortcut' => $quickReply['shortcut']],
                [
                    'title' => $quickReply['title'],
                    'body' => $quickReply['body'],
                    'is_active' => true,
                ]
            );
        }

        $tagsData = [
            ['name' => 'عميل جديد', 'color' => '#ef4444'],
            ['name' => 'مهم', 'color' => '#f59e0b'],
            ['name' => 'يحتاج متابعة', 'color' => '#22c55e'],
            ['name' => 'تم الإغلاق', 'color' => '#3b82f6'],
            ['name' => 'VIP', 'color' => '#a855f7'],
        ];

        $tags = collect($tagsData)->map(function (array $tag) use ($admin): WhatsappChatTag {
            return WhatsappChatTag::firstOrCreate(
                ['crm_user_id' => $admin->id, 'name' => $tag['name']],
                ['color' => $tag['color']]
            );
        });

        $tagAssignments = [
            0 => [0, 1],
            1 => [1, 2, 3],
            2 => [0, 2, 4],
        ];

        foreach ($conversations->values() as $conversationIndex => $conversation) {
            $tagIds = collect($tagAssignments[$conversationIndex] ?? [])
                ->map(fn (int $tagIndex): int => $tags[$tagIndex]->id)
                ->all();

            $conversation->tags()->syncWithoutDetaching($tagIds);
        }

        $broadcastsData = [
            [
                'title' => 'عرض نهاية الأسبوع',
                'status' => 'sent',
                'message_body' => 'استفد من خصم 20% على جميع المنتجات حتى نهاية الأسبوع.',
                'audience_count' => 120,
                'delivered_count' => 110,
                'failed_count' => 10,
                'scheduled_at' => null,
                'sent_at' => now()->subDays(2),
            ],
            [
                'title' => 'تذكير بالعرض القادم',
                'status' => 'scheduled',
                'message_body' => 'لا تفوّت عرضنا الجديد الذي ينطلق قريباً، ترقبوا التفاصيل.',
                'audience_count' => 200,
                'delivered_count' => 0,
                'failed_count' => 0,
                'scheduled_at' => now()->addDays(3),
                'sent_at' => null,
            ],
            [
                'title' => 'رسالة ترحيبية للعملاء الجدد',
                'status' => 'draft',
                'message_body' => 'أهلاً بك معنا، يسعدنا انضمامك ونتمنى لك تجربة رائعة.',
                'audience_count' => 0,
                'delivered_count' => 0,
                'failed_count' => 0,
                'scheduled_at' => null,
                'sent_at' => null,
            ],
        ];

        foreach ($broadcastsData as $broadcast) {
            WhatsappBroadcast::firstOrCreate(
                ['crm_user_id' => $admin->id, 'title' => $broadcast['title']],
                [
                    'whatsapp_business_setting_id' => $business->id,
                    'type' => 'custom',
                    'message_body' => $broadcast['message_body'],
                    'status' => $broadcast['status'],
                    'audience_count' => $broadcast['audience_count'],
                    'delivered_count' => $broadcast['delivered_count'],
                    'failed_count' => $broadcast['failed_count'],
                    'scheduled_at' => $broadcast['scheduled_at'],
                    'sent_at' => $broadcast['sent_at'],
                ]
            );
        }

        $businessHours = [];
        foreach (['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'] as $day) {
            $businessHours[$day] = [
                'enabled' => in_array($day, ['sun', 'mon', 'tue', 'wed', 'thu'], true),
                'from' => '09:00',
                'to' => '17:00',
            ];
        }

        WhatsappBusinessHoursSetting::updateOrCreate(
            ['crm_user_id' => $admin->id],
            [
                'timezone' => 'Asia/Riyadh',
                'business_hours_enabled' => true,
                'hours' => $businessHours,
                'away_message_enabled' => true,
                'away_message' => 'نحن خارج أوقات العمل الآن، سنتواصل معك قريباً',
            ]
        );

        $firstContact = $contacts->first();
        if ($firstContact) {
            CrmContactNote::firstOrCreate(
                ['whatsapp_contact_id' => $firstContact->id, 'crm_user_id' => $agent->id],
                ['note' => 'عميل بيستفسر كتير ومش بيشتري — يحتاج متابعة خاصة قبل أي عرض.']
            );
        }
    }
}
