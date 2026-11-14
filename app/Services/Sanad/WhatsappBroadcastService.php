<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappBroadcast;
use App\Models\CRM\WhatsappBroadcastRecipient;
use App\Models\CRM\WhatsappBusinessSetting;
use App\Models\CRM\WhatsappContact;
use App\Models\CRM\WhatsappQuickReply;
use App\Services\MainService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Throwable;

class WhatsappBroadcastService extends MainService
{
    public function __construct(
        protected WhatsappBroadcast $broadcast,
        protected WhatsappChatService $chatService,
    ) {
        $this->model = $broadcast;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function listForUser(CrmUser $user): Collection
    {
        return $this->broadcast->query()
            ->where('crm_user_id', $user->id)
            ->with(['whatsappBusinessSetting:id,name,phone_number_id'])
            ->orderByDesc('id')
            ->limit(200)
            ->get();
    }

    public function accountsForUser(CrmUser $user): Collection
    {
        return WhatsappBusinessSetting::query()
            ->where('crm_user_id', $user->id)
            ->orderBy('id')
            ->get(['id', 'name', 'phone_number_id', 'is_active']);
    }

    public function quickRepliesForUser(CrmUser $user): Collection
    {
        return WhatsappQuickReply::query()
            ->where('crm_user_id', $user->id)
            ->where('is_active', true)
            ->orderByDesc('id')
            ->limit(100)
            ->get(['id', 'title', 'body']);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function storeForUser(CrmUser $user, array $data): WhatsappBroadcast
    {
        $type = (string) $data['type'];
        $scheduledAt = $type === 'scheduled' && ! empty($data['scheduled_at'])
            ? Carbon::parse($data['scheduled_at'])
            : null;

        return $this->broadcast->query()->create([
            'crm_user_id' => $user->id,
            'whatsapp_business_setting_id' => $data['account_id'] ?? null,
            'title' => trim((string) $data['title']),
            'type' => $type,
            'message_body' => $type === 'template' ? null : trim((string) ($data['message_body'] ?? '')),
            'template_name' => $type === 'template' ? trim((string) ($data['template_name'] ?? '')) : null,
            'template_language' => $type === 'template' ? ($data['template_language'] ?? 'ar') : null,
            'button_quick_reply_ids' => $type === 'template' ? [] : $this->normalizedButtonIds($user, $data['button_quick_reply_ids'] ?? []),
            'scheduled_at' => $scheduledAt,
            'status' => $type === 'scheduled' ? 'scheduled' : 'draft',
            'audience_count' => 0,
            'delivered_count' => 0,
            'failed_count' => 0,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateForUser(CrmUser $user, int $id, array $data): WhatsappBroadcast
    {
        $broadcast = $this->findForUser($user, $id);

        abort_if($broadcast === null, 404);

        $type = (string) $data['type'];
        $scheduledAt = $type === 'scheduled' && ! empty($data['scheduled_at'])
            ? Carbon::parse($data['scheduled_at'])
            : null;

        $broadcast->fill([
            'whatsapp_business_setting_id' => $data['account_id'] ?? null,
            'title' => trim((string) $data['title']),
            'type' => $type,
            'message_body' => $type === 'template' ? null : trim((string) ($data['message_body'] ?? '')),
            'template_name' => $type === 'template' ? trim((string) ($data['template_name'] ?? '')) : null,
            'template_language' => $type === 'template' ? ($data['template_language'] ?? 'ar') : null,
            'button_quick_reply_ids' => $type === 'template' ? [] : $this->normalizedButtonIds($user, $data['button_quick_reply_ids'] ?? []),
            'scheduled_at' => $scheduledAt,
            'status' => $type === 'scheduled' ? 'scheduled' : 'draft',
        ]);

        $broadcast->save();

        return $broadcast->fresh(['whatsappBusinessSetting:id,name,phone_number_id']);
    }

    public function findForUser(CrmUser $user, int $id): ?WhatsappBroadcast
    {
        return $this->broadcast->query()
            ->where('crm_user_id', $user->id)
            ->find($id);
    }

    public function sendNowForUser(CrmUser $user, int $id): WhatsappBroadcast
    {
        $broadcast = $this->findForUser($user, $id);

        abort_if($broadcast === null, 404);

        $this->sendBatch($broadcast);

        return $broadcast->fresh(['whatsappBusinessSetting:id,name,phone_number_id']);
    }

    public function cancelForUser(CrmUser $user, int $id): ?WhatsappBroadcast
    {
        $broadcast = $this->findForUser($user, $id);

        if ($broadcast === null) {
            return null;
        }

        $broadcast->status = 'canceled';
        $broadcast->save();

        WhatsappBroadcastRecipient::query()
            ->where('broadcast_id', $broadcast->id)
            ->where('status', 'pending')
            ->update(['status' => 'canceled']);

        return $broadcast;
    }

    /**
     * @return array<string, mixed>
     */
    public function reportForUser(CrmUser $user, int $id): array
    {
        $broadcast = $this->findForUser($user, $id);

        abort_if($broadcast === null, 404);

        $items = WhatsappBroadcastRecipient::query()
            ->where('broadcast_id', $broadcast->id)
            ->leftJoin('whatsapp_contacts', function ($join) use ($user): void {
                $join->on('whatsapp_contacts.wa_id', '=', 'whatsapp_broadcast_recipients.wa_id')
                    ->where('whatsapp_contacts.crm_user_id', '=', $user->id);
            })
            ->orderByDesc('whatsapp_broadcast_recipients.id')
            ->limit(500)
            ->get([
                'whatsapp_broadcast_recipients.id',
                'whatsapp_broadcast_recipients.wa_id',
                'whatsapp_contacts.name as contact_name',
                'whatsapp_broadcast_recipients.status',
                'whatsapp_broadcast_recipients.wamid',
                'whatsapp_broadcast_recipients.error',
                'whatsapp_broadcast_recipients.sent_at',
            ]);

        return [
            'broadcast' => $broadcast,
            'items' => $items,
        ];
    }

    public function sendDueBroadcasts(): int
    {
        $broadcasts = $this->broadcast->query()
            ->where('status', 'scheduled')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at')
            ->get();

        $sent = 0;

        foreach ($broadcasts as $broadcast) {
            $this->sendBatch($broadcast);
            $sent++;
        }

        return $sent;
    }

    /**
     * @param  array<int, int|string>  $buttonIds
     * @return array<int, int>
     */
    protected function normalizedButtonIds(CrmUser $user, array $buttonIds): array
    {
        $buttonIds = array_values(array_filter(array_map('intval', $buttonIds)));

        if ($buttonIds === []) {
            return [];
        }

        $owned = WhatsappQuickReply::query()
            ->where('crm_user_id', $user->id)
            ->where('is_active', true)
            ->whereIn('id', array_slice($buttonIds, 0, 3))
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        return array_values(array_intersect($buttonIds, $owned));
    }

    protected function sendBatch(WhatsappBroadcast $broadcast): void
    {
        if (in_array($broadcast->status, ['sent', 'canceled'], true)) {
            return;
        }

        $broadcast->status = 'sending';
        $broadcast->save();

        $userId = (int) $broadcast->crm_user_id;
        $accountId = $broadcast->whatsapp_business_setting_id
            ? (int) $broadcast->whatsapp_business_setting_id
            : null;

        $buttons = $this->buttonsForBroadcast($broadcast);
        $sent = 0;
        $failed = 0;
        $audience = 0;

        WhatsappContact::query()
            ->where('crm_user_id', $userId)
            ->select(['wa_id'])
            ->orderBy('wa_id')
            ->chunk(200, function ($contacts) use ($broadcast, $userId, $accountId, $buttons, &$sent, &$failed, &$audience): void {
                foreach ($contacts as $contact) {
                    $waId = trim((string) $contact->wa_id);

                    if ($waId === '') {
                        continue;
                    }

                    $audience++;

                    $recipient = WhatsappBroadcastRecipient::query()->updateOrCreate(
                        [
                            'broadcast_id' => $broadcast->id,
                            'wa_id' => $waId,
                        ],
                        [
                            'status' => 'pending',
                            'wamid' => null,
                            'error' => null,
                            'sent_at' => null,
                            'delivered_at' => null,
                        ]
                    );

                    try {
                        $result = $this->dispatchMessage($broadcast, $userId, $waId, $accountId, $buttons);

                        $recipient->status = 'sent';
                        $recipient->wamid = data_get($result, 'messages.0.id');
                        $recipient->sent_at = now();
                        $recipient->save();
                        $sent++;
                    } catch (Throwable $e) {
                        $recipient->status = 'failed';
                        $recipient->error = $e->getMessage();
                        $recipient->save();
                        $failed++;
                    }
                }
            });

        $broadcast->status = 'sent';
        $broadcast->sent_at = now();
        $broadcast->audience_count = $audience;
        $broadcast->delivered_count = $sent;
        $broadcast->failed_count = $failed;
        $broadcast->save();
    }

    /**
     * @param  array<int, array{id: string, title: string}>  $buttons
     * @return array<string, mixed>
     */
    protected function dispatchMessage(
        WhatsappBroadcast $broadcast,
        int $userId,
        string $waId,
        ?int $accountId,
        array $buttons
    ): array {
        if ($broadcast->type === 'template') {
            return $this->chatService->sendTemplateMessage(
                $userId,
                $waId,
                (string) $broadcast->template_name,
                $broadcast->template_language ?: 'ar',
                $accountId
            );
        }

        if ($buttons !== []) {
            $body = trim((string) $broadcast->message_body);

            return $this->chatService->sendInteractiveButtonsMessage(
                $userId,
                $waId,
                $body !== '' ? $body : (string) $broadcast->title,
                $buttons,
                $accountId
            );
        }

        return $this->chatService->sendTextMessage(
            $userId,
            $waId,
            (string) $broadcast->message_body,
            $accountId
        );
    }

    /**
     * @return array<int, array{id: string, title: string}>
     */
    protected function buttonsForBroadcast(WhatsappBroadcast $broadcast): array
    {
        if ($broadcast->type === 'template') {
            return [];
        }

        $ids = is_array($broadcast->button_quick_reply_ids)
            ? array_slice(array_values(array_filter(array_map('intval', $broadcast->button_quick_reply_ids))), 0, 3)
            : [];

        if ($ids === []) {
            return [];
        }

        $replies = WhatsappQuickReply::query()
            ->where('crm_user_id', $broadcast->crm_user_id)
            ->where('is_active', true)
            ->whereIn('id', $ids)
            ->orderBy('id')
            ->get(['id', 'title']);

        $buttons = [];

        foreach ($replies as $reply) {
            $title = trim((string) $reply->title);

            if ($title === '') {
                continue;
            }

            $buttons[] = [
                'id' => 'qr_'.$reply->id,
                'title' => mb_substr($title, 0, 20),
            ];
        }

        return $buttons;
    }
}
