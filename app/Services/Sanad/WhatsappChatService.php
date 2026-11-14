<?php

namespace App\Services\Sanad;

use App\Models\CRM\WhatsappBusinessHoursSetting;
use App\Models\CRM\WhatsappBusinessSetting;
use App\Models\CRM\WhatsappChatTag;
use App\Models\CRM\WhatsappContact;
use App\Models\CRM\WhatsappConversation;
use App\Models\CRM\WhatsappConversationNote;
use App\Models\CRM\WhatsappMessage;
use App\Models\CRM\WhatsappQuickReply;
use App\Repositories\Contracts\WhatsappBusinessRepositoryInterface;
use App\Services\MainService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class WhatsappChatService extends MainService
{
    public function __construct(
        protected WhatsappBusinessRepositoryInterface $repository,
    ) {}

    public function resolveActiveSetting(int $crmUserId, ?int $accountId = null): WhatsappBusinessSetting
    {
        $query = WhatsappBusinessSetting::query()
            ->where('crm_user_id', $crmUserId)
            ->where('is_active', true);

        if ($accountId !== null) {
            $query->where('id', $accountId);
        }

        $settings = $query->orderBy('id')->first();

        if (! $settings) {
            throw new RuntimeException('WhatsApp Business settings not configured or not active.');
        }

        if (! $settings->phone_number_id || ! $settings->access_token) {
            throw new RuntimeException('WhatsApp Business settings missing required fields.');
        }

        if (! $settings->api_version) {
            throw new RuntimeException('WhatsApp Business settings missing api_version.');
        }

        return $settings;
    }

    public function sendTextMessage(
        int $crmUserId,
        string $to,
        string $body,
        ?int $accountId = null,
        ?string $replyToWamid = null
    ): array {
        $toNormalized = $this->normalizeWaId($to) ?: $to;
        $settings = $this->resolveActiveSetting($crmUserId, $accountId);

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $toNormalized,
            'type' => 'text',
            'text' => [
                'preview_url' => false,
                'body' => $body,
            ],
        ];

        if ($replyToWamid) {
            $payload['context'] = ['message_id' => $replyToWamid];
        }

        $result = $this->repository->sendMessage(
            $settings->api_version,
            $settings->phone_number_id,
            $settings->access_token,
            $payload
        );

        if ($replyToWamid) {
            $result['reply_to_message_id'] = $replyToWamid;
        }

        $this->storeOutgoingMessage($crmUserId, $toNormalized, 'text', $body, $result, $settings);

        Log::info('whatsapp.send.text.success', [
            'to' => $this->maskValue($toNormalized),
            'wamid' => Arr::get($result, 'messages.0.id'),
        ]);

        return $result;
    }

    public function sendTemplateMessage(
        int $crmUserId,
        string $to,
        string $templateName,
        string $languageCode = 'ar',
        ?int $accountId = null
    ): array {
        $toNormalized = $this->normalizeWaId($to) ?: $to;
        $settings = $this->resolveActiveSetting($crmUserId, $accountId);

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $toNormalized,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => ['code' => $languageCode],
            ],
        ];

        $result = $this->repository->sendMessage(
            $settings->api_version,
            $settings->phone_number_id,
            $settings->access_token,
            $payload
        );

        $this->storeOutgoingMessage($crmUserId, $toNormalized, 'template', 'TEMPLATE: '.$templateName, $result, $settings);

        return $result;
    }

    public function sendInteractiveButtonsMessage(
        int $crmUserId,
        string $to,
        string $bodyText,
        array $buttons,
        ?int $accountId = null
    ): array {
        $toNormalized = $this->normalizeWaId($to) ?: $to;
        $settings = $this->resolveActiveSetting($crmUserId, $accountId);

        $normalizedButtons = [];
        foreach ($buttons as $button) {
            if (! is_array($button)) {
                continue;
            }

            $id = isset($button['id']) ? trim((string) $button['id']) : '';
            $title = isset($button['title']) ? trim((string) $button['title']) : '';

            if ($id === '' || $title === '') {
                continue;
            }

            if (mb_strlen($title) > 20) {
                $title = mb_substr($title, 0, 20);
            }

            $normalizedButtons[] = [
                'type' => 'reply',
                'reply' => [
                    'id' => $id,
                    'title' => $title,
                ],
            ];
        }

        $normalizedButtons = array_slice($normalizedButtons, 0, 3);

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $toNormalized,
            'type' => 'interactive',
            'interactive' => [
                'type' => 'button',
                'body' => ['text' => $bodyText],
                'action' => ['buttons' => $normalizedButtons],
            ],
        ];

        $result = $this->repository->sendMessage(
            $settings->api_version,
            $settings->phone_number_id,
            $settings->access_token,
            $payload
        );

        $this->storeOutgoingMessage($crmUserId, $toNormalized, 'interactive', $bodyText, $result, $settings);

        return $result;
    }

    public function sendUploadedMediaMessage(
        int $crmUserId,
        string $to,
        string $uploadedFilePath,
        string $mimeType,
        string $fileName,
        ?string $caption = null,
        ?string $forceType = null,
        ?string $replyToWamid = null,
        ?int $accountId = null
    ): array {
        $toNormalized = $this->normalizeWaId($to) ?: $to;
        $settings = $this->resolveActiveSetting($crmUserId, $accountId);

        $type = $this->detectMediaType($mimeType, $forceType);
        if ($type === 'audio') {
            $mimeType = $this->normalizeOutgoingAudioMimeType($mimeType, $fileName);
        }

        $normalizedFileName = $this->normalizeMediaFileName($fileName, $mimeType);
        $localMediaMeta = $this->storeLocalOutgoingMediaPreview($uploadedFilePath, $mimeType, $normalizedFileName);

        $upload = $this->repository->uploadMedia(
            $settings->api_version,
            $settings->phone_number_id,
            $settings->access_token,
            $uploadedFilePath,
            $mimeType,
            $normalizedFileName
        );

        $mediaId = Arr::get($upload, 'id');
        if (! $mediaId) {
            throw new RuntimeException('WhatsApp media upload did not return id.');
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $toNormalized,
            'type' => $type,
        ];

        if ($replyToWamid) {
            $payload['context'] = ['message_id' => $replyToWamid];
        }

        $caption = $caption !== null ? trim((string) $caption) : null;
        if ($caption === '') {
            $caption = null;
        }

        if ($type === 'image') {
            $payload['image'] = ['id' => $mediaId];
            if ($caption) {
                $payload['image']['caption'] = $caption;
            }
        } elseif ($type === 'video') {
            $payload['video'] = ['id' => $mediaId];
            if ($caption) {
                $payload['video']['caption'] = $caption;
            }
        } elseif ($type === 'audio') {
            $payload['audio'] = ['id' => $mediaId];
        } else {
            $type = 'document';
            $payload['type'] = 'document';
            $payload['document'] = [
                'id' => $mediaId,
                'filename' => $normalizedFileName,
            ];
            if ($caption) {
                $payload['document']['caption'] = $caption;
            }
        }

        $result = $this->repository->sendMessage(
            $settings->api_version,
            $settings->phone_number_id,
            $settings->access_token,
            $payload
        );

        $body = $caption;
        if ($type === 'document' && ! $body) {
            $body = $normalizedFileName;
        }

        $apiResult = $result;
        $apiResult['uploaded_media_id'] = $mediaId;
        if ($replyToWamid) {
            $apiResult['reply_to_message_id'] = $replyToWamid;
        }
        if ($localMediaMeta !== null) {
            $apiResult['local_media_disk'] = $localMediaMeta['disk'];
            $apiResult['local_media_path'] = $localMediaMeta['path'];
            $apiResult['local_media_mime'] = $localMediaMeta['mime'];
        }

        $this->storeOutgoingMessage($crmUserId, $toNormalized, $type, $body, $apiResult, $settings);

        return $result;
    }

    public function markIncomingMessageAsRead(int $crmUserId, string $messageId, ?int $accountId = null): array
    {
        $settings = $this->resolveActiveSetting($crmUserId, $accountId);

        return $this->repository->markAsRead(
            $settings->api_version,
            $settings->phone_number_id,
            $settings->access_token,
            $messageId
        );
    }

    public function deleteMessage(int $crmUserId, string $wamid, ?int $accountId = null): array
    {
        $wamid = trim($wamid);
        if ($wamid === '') {
            throw new RuntimeException('WhatsApp message id missing.');
        }

        $settings = $this->resolveActiveSetting($crmUserId, $accountId);

        $message = WhatsappMessage::query()
            ->where('crm_user_id', $crmUserId)
            ->where('direction', 'out')
            ->where('wamid', $wamid)
            ->first();

        if (! $message) {
            throw new RuntimeException('WhatsApp message not found.');
        }

        $result = ['local_deleted' => true, 'remote_deleted' => false];

        if (filter_var(env('WHATSAPP_REMOTE_DELETE_ENABLED', false), FILTER_VALIDATE_BOOLEAN)) {
            $response = $this->repository->sendMessage(
                $settings->api_version,
                $settings->phone_number_id,
                $settings->access_token,
                [
                    'messaging_product' => 'whatsapp',
                    'status' => 'deleted',
                    'message_id' => $wamid,
                ]
            );

            $result['remote_deleted'] = (bool) Arr::get($response, 'success', false);
        }

        $message->message_status = 'deleted';
        $message->save();

        return $result;
    }

    public function normalizeWebhookPayload(array $payload): array
    {
        $allMessages = [];
        $allStatuses = [];
        $allContacts = [];
        $phoneNumberId = null;
        $displayPhoneNumber = null;

        foreach (Arr::get($payload, 'entry', []) as $entry) {
            foreach (Arr::get($entry, 'changes', []) as $change) {
                $value = Arr::get($change, 'value', []);

                if (! $phoneNumberId) {
                    $metadata = Arr::get($value, 'metadata', []);
                    $phoneNumberId = Arr::get($metadata, 'phone_number_id');
                    $displayPhoneNumber = Arr::get($metadata, 'display_phone_number');
                }

                foreach (Arr::get($value, 'contacts', []) as $contact) {
                    $allContacts[] = $contact;
                }

                foreach (Arr::get($value, 'messages', []) as $message) {
                    $type = Arr::get($message, 'type');
                    $allMessages[] = [
                        'message_id' => Arr::get($message, 'id'),
                        'from' => Arr::get($message, 'from'),
                        'timestamp' => Arr::get($message, 'timestamp'),
                        'type' => $type,
                        'text' => Arr::get($message, 'text.body'),
                        'body' => $this->extractIncomingBody($message, $type),
                        'raw' => $message,
                    ];
                }

                foreach (Arr::get($value, 'statuses', []) as $status) {
                    $allStatuses[] = [
                        'message_id' => Arr::get($status, 'id'),
                        'recipient_id' => $this->normalizeWaId((string) Arr::get($status, 'recipient_id')),
                        'status' => $this->normalizeOutgoingMessageStatus(Arr::get($status, 'status')),
                        'timestamp' => Arr::get($status, 'timestamp'),
                        'raw' => $status,
                    ];
                }
            }
        }

        return [
            'phone_number_id' => $phoneNumberId,
            'display_phone_number' => $displayPhoneNumber,
            'contacts' => $allContacts,
            'messages' => $allMessages,
            'statuses' => $allStatuses,
            'raw' => $payload,
        ];
    }

    public function storeIncomingWebhookPayload(array $payload): array
    {
        $normalized = $this->normalizeWebhookPayload($payload);

        $phoneNumberId = Arr::get($normalized, 'phone_number_id');
        if (! $phoneNumberId) {
            return $this->emptyWebhookResult();
        }

        $settings = WhatsappBusinessSetting::query()
            ->where('phone_number_id', $phoneNumberId)
            ->first();

        if (! $settings) {
            return $this->emptyWebhookResult();
        }

        $crmUserId = (int) $settings->crm_user_id;
        $settingId = $settings->id;

        $contacts = Arr::get($normalized, 'contacts', []);
        $displayName = Arr::get($contacts, '0.profile.name');
        $waId = $this->normalizeWaId((string) Arr::get($contacts, '0.wa_id'));

        $conversation = null;
        if ($waId !== '') {
            $conversation = $this->findOrCreateConversation($crmUserId, $waId, $settingId, $displayName);
            $this->touchContact($crmUserId, $waId, $displayName);
        }

        $created = [];
        $updated = [];
        $stored = [];

        $updatedFromStatuses = $this->applyWebhookStatuses($crmUserId, Arr::get($normalized, 'statuses', []));

        if (! $conversation && ! empty($updatedFromStatuses['conversation_id'])) {
            $conversation = WhatsappConversation::query()
                ->where('crm_user_id', $crmUserId)
                ->find($updatedFromStatuses['conversation_id']);
        }

        $newInboundCount = 0;

        foreach (Arr::get($normalized, 'messages', []) as $messagePayload) {
            $from = $this->normalizeWaId((string) Arr::get($messagePayload, 'from'));
            $wamid = Arr::get($messagePayload, 'message_id');
            $type = Arr::get($messagePayload, 'type') ?: 'text';
            $body = Arr::get($messagePayload, 'body') ?? Arr::get($messagePayload, 'text');
            $timestamp = Arr::get($messagePayload, 'timestamp');

            if (! $conversation && $from !== '') {
                $conversation = $this->findOrCreateConversation($crmUserId, $from, $settingId, $displayName);
            }

            if (! $conversation) {
                continue;
            }

            $waTimestamp = $timestamp ? Carbon::createFromTimestamp((int) $timestamp) : null;

            $attributes = [
                'conversation_id' => $conversation->id,
                'crm_user_id' => $crmUserId,
                'whatsapp_business_setting_id' => $settingId,
                'wamid' => $wamid ?: null,
                'direction' => 'in',
                'from_wa_id' => $from,
                'to_wa_id' => $phoneNumberId,
                'type' => $type,
                'message_status' => null,
                'body' => $body,
                'wa_timestamp' => $waTimestamp,
                'raw' => Arr::get($messagePayload, 'raw'),
            ];

            $isNew = false;
            if ($wamid) {
                $message = WhatsappMessage::query()
                    ->where('crm_user_id', $crmUserId)
                    ->where('wamid', $wamid)
                    ->first();

                if (! $message) {
                    $message = WhatsappMessage::query()->create($attributes);
                    $isNew = true;
                    $created[] = $message->id;
                } else {
                    $message->update($attributes);
                    $updated[] = $message->id;
                }
            } else {
                $message = WhatsappMessage::query()->create($attributes);
                $isNew = true;
                $created[] = $message->id;
            }

            $stored[] = $message->id;

            $updateData = ['last_message_at' => $waTimestamp ?: now()];
            if ($isNew) {
                $updateData['unread_count'] = ($conversation->unread_count ?? 0) + 1;
                $newInboundCount++;
            }
            $conversation->update($updateData);

            $contactWaId = $waId ?: $from;
            if ($contactWaId !== '') {
                $this->touchContact($crmUserId, $contactWaId, $displayName, $waTimestamp ?: now());
            }
        }

        $awayReplySent = false;
        if ($newInboundCount > 0 && $conversation) {
            $awayReplySent = $this->sendAwayReplyIfNeeded($crmUserId, $conversation, $settings);
        }

        return [
            'conversation_id' => $conversation ? $conversation->id : null,
            'incoming_message_count' => count(Arr::get($normalized, 'messages', [])),
            'status_count' => count(Arr::get($normalized, 'statuses', [])),
            'created_message_ids' => array_values(array_unique($created)),
            'updated_message_ids' => array_values(array_unique($updated)),
            'status_updated_message_ids' => array_values(array_unique($updatedFromStatuses['message_ids'])),
            'message_ids' => array_values(array_unique(array_merge($updatedFromStatuses['message_ids'], $stored))),
            'away_reply_sent' => $awayReplySent,
        ];
    }

    protected function emptyWebhookResult(): array
    {
        return [
            'conversation_id' => null,
            'incoming_message_count' => 0,
            'status_count' => 0,
            'created_message_ids' => [],
            'updated_message_ids' => [],
            'status_updated_message_ids' => [],
            'message_ids' => [],
            'away_reply_sent' => false,
        ];
    }

    protected function findOrCreateConversation(
        int $crmUserId,
        string $waId,
        ?int $settingId,
        ?string $displayName
    ): WhatsappConversation {
        $conversation = WhatsappConversation::query()->firstOrCreate(
            [
                'crm_user_id' => $crmUserId,
                'wa_id' => $waId,
                'whatsapp_business_setting_id' => $settingId,
            ],
            ['display_name' => $displayName]
        );

        if ($displayName && $conversation->display_name !== $displayName) {
            $conversation->update(['display_name' => $displayName]);
        }

        return $conversation;
    }

    protected function touchContact(
        int $crmUserId,
        string $waId,
        ?string $displayName,
        ?Carbon $lastActivity = null
    ): WhatsappContact {
        $contact = WhatsappContact::query()->firstOrCreate(
            [
                'crm_user_id' => $crmUserId,
                'wa_id' => $waId,
            ],
            [
                'name' => $displayName,
                'registered_at' => now(),
            ]
        );

        $newLastActivity = $lastActivity ?: now();

        if ($displayName && $contact->name !== $displayName) {
            $contact->name = $displayName;
        }

        if (! $contact->last_activity || $newLastActivity->greaterThan($contact->last_activity)) {
            $contact->last_activity = $newLastActivity;
        }

        $contact->save();

        return $contact;
    }

    protected function storeOutgoingMessage(
        int $crmUserId,
        string $to,
        string $type,
        ?string $body,
        array $apiResult,
        WhatsappBusinessSetting $settings
    ): void {
        $toNormalized = $this->normalizeWaId($to) ?: $to;

        $conversation = WhatsappConversation::query()->firstOrCreate([
            'crm_user_id' => $crmUserId,
            'wa_id' => $toNormalized,
            'whatsapp_business_setting_id' => $settings->id,
        ]);

        $wamid = Arr::get($apiResult, 'messages.0.id');

        $attributes = [
            'conversation_id' => $conversation->id,
            'crm_user_id' => $crmUserId,
            'whatsapp_business_setting_id' => $settings->id,
            'direction' => 'out',
            'from_wa_id' => $settings->phone_number_id,
            'to_wa_id' => $toNormalized,
            'type' => $type ?: 'text',
            'message_status' => 'sent',
            'body' => $body,
            'wa_timestamp' => now(),
            'raw' => $apiResult,
        ];

        if ($wamid) {
            $message = WhatsappMessage::query()->updateOrCreate(
                ['wamid' => $wamid],
                $attributes + ['wamid' => $wamid]
            );
        } else {
            $message = WhatsappMessage::query()->create($attributes);
        }

        $conversation->last_message_at = $message->wa_timestamp ?: now();
        $conversation->save();

        $this->touchContact($crmUserId, $toNormalized, null, $message->wa_timestamp ?: now());
    }

    protected function applyWebhookStatuses(int $crmUserId, array $statuses): array
    {
        $updatedIds = [];
        $conversationId = null;

        foreach ($statuses as $statusPayload) {
            $wamid = Arr::get($statusPayload, 'message_id');
            $nextStatus = $this->normalizeOutgoingMessageStatus(Arr::get($statusPayload, 'status'));

            if (! $wamid || ! $nextStatus) {
                continue;
            }

            $message = WhatsappMessage::query()
                ->where('crm_user_id', $crmUserId)
                ->where('direction', 'out')
                ->where('wamid', $wamid)
                ->first();

            if (! $message || ! $this->shouldUpdateMessageStatus($message->message_status, $nextStatus)) {
                continue;
            }

            $message->message_status = $nextStatus;

            if (Arr::exists($statusPayload, 'raw')) {
                $raw = is_array($message->raw) ? $message->raw : [];
                $raw['last_status_update'] = $statusPayload['raw'];
                $message->raw = $raw;
            }

            $message->save();

            $updatedIds[] = $message->id;
            $conversationId ??= $message->conversation_id;
        }

        return [
            'conversation_id' => $conversationId,
            'message_ids' => $updatedIds,
        ];
    }

    protected function sendAwayReplyIfNeeded(
        int $crmUserId,
        WhatsappConversation $conversation,
        WhatsappBusinessSetting $settings
    ): bool {
        $hours = WhatsappBusinessHoursSetting::query()
            ->where('crm_user_id', $crmUserId)
            ->first();

        if (! $hours || ! $hours->away_message_enabled || ! $hours->business_hours_enabled) {
            return false;
        }

        $awayMessage = trim((string) $hours->away_message);
        if ($awayMessage === '') {
            return false;
        }

        $timezone = $hours->timezone ?: config('app.timezone', 'UTC');

        try {
            $now = Carbon::now($timezone);
        } catch (\Throwable) {
            $now = Carbon::now();
        }

        $windowStart = $this->closedWindowStart($now, $hours->hours ?? []);
        if ($windowStart === null) {
            return false;
        }

        $alreadySent = WhatsappMessage::query()
            ->where('conversation_id', $conversation->id)
            ->where('crm_user_id', $crmUserId)
            ->where('direction', 'out')
            ->where('type', 'text')
            ->where('body', $awayMessage)
            ->where(function ($query) use ($windowStart) {
                $query->where('wa_timestamp', '>=', $windowStart)
                    ->orWhere(function ($query) use ($windowStart) {
                        $query->whereNull('wa_timestamp')->where('created_at', '>=', $windowStart);
                    });
            })
            ->exists();

        if ($alreadySent) {
            return false;
        }

        try {
            $this->sendTextMessage($crmUserId, $conversation->wa_id, $awayMessage, $settings->id);
        } catch (\Throwable $e) {
            Log::warning('whatsapp.away_reply.failed', [
                'conversation_id' => $conversation->id,
                'crm_user_id' => $crmUserId,
                'error' => $e->getMessage(),
            ]);

            return false;
        }

        return true;
    }

    /**
     * Return the start of the currently closed window, or null when within business hours.
     *
     * @param  array<string, array{open?: bool, from?: string, to?: string}>  $hours
     */
    protected function closedWindowStart(Carbon $now, array $hours): ?Carbon
    {
        $dayKeys = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];
        $day = $dayKeys[((int) $now->format('w') + 1) % 7];
        $row = $hours[$day] ?? null;

        if (! is_array($row) || empty($row['open'])) {
            return $now->copy()->startOfDay();
        }

        $from = (string) ($row['from'] ?? '');
        $to = (string) ($row['to'] ?? '');

        if (! preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $from) || ! preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $to)) {
            return null;
        }

        $opensAt = $now->copy()->setTimeFromTimeString($from);
        $closesAt = $now->copy()->setTimeFromTimeString($to);

        if ($now->lt($opensAt)) {
            return $now->copy()->startOfDay();
        }

        if ($now->lt($closesAt)) {
            return null;
        }

        return $closesAt;
    }

    protected function normalizeOutgoingMessageStatus(mixed $status): ?string
    {
        if ($status === null) {
            return null;
        }

        $value = strtolower(trim((string) $status));

        if ($value === 'accepted') {
            return 'sent';
        }

        return in_array($value, ['sent', 'delivered', 'read'], true) ? $value : null;
    }

    protected function shouldUpdateMessageStatus(?string $currentStatus, string $nextStatus): bool
    {
        return $this->messageStatusRank($nextStatus) > $this->messageStatusRank($currentStatus);
    }

    protected function messageStatusRank(?string $status): int
    {
        return match ($status) {
            'read' => 3,
            'delivered' => 2,
            'sent' => 1,
            default => 0,
        };
    }

    protected function extractIncomingBody(array $message, ?string $type): ?string
    {
        return match ($type) {
            'text' => Arr::get($message, 'text.body'),
            'button' => Arr::get($message, 'button.text'),
            'interactive' => Arr::get($message, 'interactive.button_reply.title')
                ?: Arr::get($message, 'interactive.list_reply.title')
                ?: json_encode(Arr::get($message, 'interactive'), JSON_UNESCAPED_UNICODE),
            'image' => Arr::get($message, 'image.caption'),
            'document' => Arr::get($message, 'document.caption')
                ?: $this->normalizeMediaFileName((string) Arr::get($message, 'document.filename'), 'application/octet-stream'),
            'video' => Arr::get($message, 'video.caption'),
            'audio', 'sticker' => null,
            default => $type ?: null,
        };
    }

    protected function detectMediaType(string $mimeType, ?string $forceType = null): string
    {
        $forceType = $forceType !== null ? strtolower(trim($forceType)) : null;
        if (in_array($forceType, ['image', 'video', 'audio', 'document'], true)) {
            return $forceType;
        }

        $mime = strtolower(trim($mimeType));

        if (str_starts_with($mime, 'image/')) {
            return 'image';
        }

        if (str_starts_with($mime, 'video/')) {
            return 'video';
        }

        if (str_starts_with($mime, 'audio/')) {
            return 'audio';
        }

        return 'document';
    }

    protected function normalizeOutgoingAudioMimeType(string $mimeType, string $fileName): string
    {
        $mime = strtolower(trim($mimeType));
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($mime === '') {
            $mime = 'application/octet-stream';
        }

        if ($mime === 'video/mp4' || $mime === 'application/mp4') {
            return 'audio/mp4';
        }

        if ($mime === 'video/webm' || str_starts_with($mime, 'audio/webm')) {
            return 'audio/ogg; codecs=opus';
        }

        if ($mime === 'application/octet-stream') {
            return match ($extension) {
                'm4a', 'mp4' => 'audio/mp4',
                'ogg', 'opus', 'webm' => 'audio/ogg; codecs=opus',
                'mp3' => 'audio/mpeg',
                'aac' => 'audio/aac',
                'amr' => 'audio/amr',
                default => $mime,
            };
        }

        if (in_array($extension, ['ogg', 'opus', 'webm'], true) && ! str_starts_with($mime, 'audio/ogg')) {
            return 'audio/ogg; codecs=opus';
        }

        if ($mime === 'application/ogg' || $mime === 'audio/ogg') {
            return 'audio/ogg; codecs=opus';
        }

        if ($mime === 'audio/mpeg' || $mime === 'audio/mp3') {
            return 'audio/mpeg';
        }

        return $mimeType;
    }

    protected function normalizeMediaFileName(string $fileName, string $mimeType): string
    {
        $fileName = trim(basename($fileName));
        if ($fileName === '' || $fileName === '.' || $fileName === '..') {
            $fileName = 'file';
        }

        $mime = strtolower(trim($mimeType));
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $nameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

        if ($extension === 'webm' && str_starts_with($mime, 'audio/ogg')) {
            return $nameWithoutExtension.'.ogg';
        }

        return $fileName;
    }

    protected function storeLocalOutgoingMediaPreview(string $filePath, string $mimeType, string $fileName): ?array
    {
        if (! is_file($filePath) || ! is_readable($filePath)) {
            return null;
        }

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $safeExtension = preg_match('/^[a-z0-9]{1,10}$/', $extension) ? $extension : 'bin';
        $relativePath = 'whatsapp-chat-media/'.now()->format('Y/m').'/'.Str::uuid()->toString().'.'.$safeExtension;
        $disk = Storage::disk('public');

        $stream = @fopen($filePath, 'r');
        if (! $stream) {
            return null;
        }

        try {
            $stored = $disk->put($relativePath, $stream);
        } finally {
            fclose($stream);
        }

        if (! $stored) {
            return null;
        }

        return [
            'disk' => 'public',
            'path' => $relativePath,
            'mime' => $mimeType,
        ];
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array{items: Collection, pagination: array<string, int|null|bool>}
     */
    public function listConversations(int $crmUserId, array $filters = []): array
    {
        $limit = max(1, min((int) ($filters['limit'] ?? 50), 200));
        $offset = max(0, (int) ($filters['offset'] ?? 0));
        $status = trim((string) ($filters['status'] ?? ''));
        $search = trim((string) ($filters['search'] ?? ''));
        $tagId = isset($filters['tag_id']) && $filters['tag_id'] !== '' ? (int) $filters['tag_id'] : null;
        $accountId = isset($filters['account_id']) && $filters['account_id'] !== '' ? (int) $filters['account_id'] : null;

        $query = WhatsappConversation::query()
            ->select([
                'whatsapp_conversations.id',
                'whatsapp_conversations.crm_user_id',
                'whatsapp_conversations.whatsapp_business_setting_id',
                'whatsapp_conversations.wa_id',
                'whatsapp_conversations.display_name',
                'whatsapp_conversations.status',
                'whatsapp_conversations.resolved_at',
                'whatsapp_conversations.last_message_at',
                'whatsapp_conversations.unread_count',
            ])
            ->addSelect([
                'profile_pic' => WhatsappContact::query()
                    ->select('profile_pic')
                    ->whereColumn('whatsapp_contacts.wa_id', 'whatsapp_conversations.wa_id')
                    ->where('whatsapp_contacts.crm_user_id', $crmUserId)
                    ->limit(1),
            ])
            ->where('whatsapp_conversations.crm_user_id', $crmUserId)
            ->with(['lastMessage', 'tags:id,name,color']);

        if ($status !== '' && in_array($status, ['open', 'resolved'], true)) {
            $query->where('whatsapp_conversations.status', $status);
        }

        if ($accountId !== null) {
            $query->where('whatsapp_conversations.whatsapp_business_setting_id', $accountId);
        }

        if ($search !== '') {
            $like = '%'.$search.'%';
            $query->where(function ($inner) use ($like): void {
                $inner->where('whatsapp_conversations.wa_id', 'like', $like)
                    ->orWhere('whatsapp_conversations.display_name', 'like', $like);
            });
        }

        if ($tagId !== null) {
            $ownedTagId = WhatsappChatTag::query()
                ->where('crm_user_id', $crmUserId)
                ->where('id', $tagId)
                ->value('id');

            if ($ownedTagId === null) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereHas('tags', function ($inner) use ($ownedTagId): void {
                    $inner->where('whatsapp_chat_tags.id', $ownedTagId);
                });
            }
        }

        $items = $query
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->offset($offset)
            ->limit($limit + 1)
            ->get();

        $hasMore = $items->count() > $limit;
        if ($hasMore) {
            $items = $items->take($limit)->values();
        }

        return [
            'items' => $items,
            'pagination' => [
                'limit' => $limit,
                'offset' => $offset,
                'next_offset' => $hasMore ? $offset + $limit : null,
                'has_more' => $hasMore,
            ],
        ];
    }

    /**
     * @return array{conversation: WhatsappConversation, items: Collection, has_more: bool, next_before_id: int|null}
     */
    public function conversationMessages(int $crmUserId, int $conversationId, ?int $beforeId = null, int $limit = 50): array
    {
        $limit = max(1, min($limit, 200));

        $conversation = $this->findOwnedConversation($crmUserId, $conversationId);

        if ((int) $conversation->unread_count > 0) {
            $conversation->forceFill(['unread_count' => 0])->save();
        }

        $query = WhatsappMessage::query()
            ->where('conversation_id', $conversation->id)
            ->where('crm_user_id', $crmUserId)
            ->orderByDesc('id');

        if ($beforeId !== null) {
            $query->where('id', '<', $beforeId);
        }

        $items = $query->limit($limit + 1)->get();

        $hasMore = $items->count() > $limit;
        if ($hasMore) {
            $items = $items->take($limit)->values();
        }

        return [
            'conversation' => $conversation,
            'items' => $items,
            'has_more' => $hasMore,
            'next_before_id' => $items->last()?->id,
        ];
    }

    /**
     * @return array{items: Collection, query: string}
     */
    public function searchConversationMessages(int $crmUserId, int $conversationId, string $q, int $limit = 20): array
    {
        $limit = max(1, min($limit, 100));

        $conversation = $this->findOwnedConversation($crmUserId, $conversationId);
        $search = trim($q);

        if ($search === '') {
            return ['items' => new Collection, 'query' => $search];
        }

        $items = WhatsappMessage::query()
            ->where('conversation_id', $conversation->id)
            ->where('crm_user_id', $crmUserId)
            ->where(function ($query) use ($search): void {
                $query->where('body', 'like', '%'.$search.'%')
                    ->orWhere('type', 'like', '%'.$search.'%');
            })
            ->orderByDesc('id')
            ->limit($limit)
            ->get([
                'id',
                'conversation_id',
                'wamid',
                'direction',
                'from_wa_id',
                'to_wa_id',
                'type',
                'message_status',
                'body',
                'wa_timestamp',
                'created_at',
            ]);

        return ['items' => $items, 'query' => $search];
    }

    /**
     * @return array{conversation: array<string, mixed>, account: array<string, mixed>|null, tags: Collection, notes: Collection}
     */
    public function conversationMeta(int $crmUserId, int $conversationId): array
    {
        $conversation = $this->findOwnedConversation($crmUserId, $conversationId);
        $conversation->load(['tags:id,name,color', 'whatsappBusinessSetting:id,name,phone_number_id']);

        $notes = WhatsappConversationNote::query()
            ->with(['crmUser:id,name'])
            ->where('conversation_id', $conversation->id)
            ->where('crm_user_id', $crmUserId)
            ->orderByDesc('id')
            ->limit(20)
            ->get()
            ->map(fn (WhatsappConversationNote $note): array => [
                'id' => $note->id,
                'body' => $note->body,
                'created_at' => $note->created_at,
                'user' => $note->crmUser
                    ? ['id' => $note->crmUser->id, 'name' => $note->crmUser->name]
                    : null,
            ])
            ->values();

        return [
            'conversation' => [
                'id' => $conversation->id,
                'wa_id' => $conversation->wa_id,
                'display_name' => $conversation->display_name,
                'whatsapp_business_setting_id' => $conversation->whatsapp_business_setting_id,
                'status' => $conversation->status ?: 'open',
                'resolved_at' => $conversation->resolved_at,
                'unread_count' => $conversation->unread_count,
                'last_message_at' => $conversation->last_message_at,
            ],
            'account' => $conversation->whatsappBusinessSetting
                ? [
                    'id' => $conversation->whatsappBusinessSetting->id,
                    'name' => $conversation->whatsappBusinessSetting->name,
                    'phone_number_id' => $conversation->whatsappBusinessSetting->phone_number_id,
                ]
                : null,
            'tags' => $conversation->tags->map(fn (WhatsappChatTag $tag): array => [
                'id' => $tag->id,
                'name' => $tag->name,
                'color' => $tag->color,
            ])->values(),
            'notes' => $notes,
        ];
    }

    /**
     * @param  array<int, int|string>  $tagIds
     */
    public function setConversationTags(int $crmUserId, int $conversationId, array $tagIds): Collection
    {
        $conversation = $this->findOwnedConversation($crmUserId, $conversationId);

        $ownedTagIds = WhatsappChatTag::query()
            ->where('crm_user_id', $crmUserId)
            ->whereIn('id', array_map('intval', $tagIds))
            ->pluck('id')
            ->all();

        $conversation->tags()->sync($ownedTagIds);

        return $conversation->tags()->get(['whatsapp_chat_tags.id', 'whatsapp_chat_tags.name', 'whatsapp_chat_tags.color']);
    }

    public function addConversationNote(int $crmUserId, int $conversationId, string $body): WhatsappConversationNote
    {
        $conversation = $this->findOwnedConversation($crmUserId, $conversationId);

        return WhatsappConversationNote::query()->create([
            'conversation_id' => $conversation->id,
            'crm_user_id' => $crmUserId,
            'body' => trim($body),
        ]);
    }

    public function toggleResolve(int $crmUserId, int $conversationId): WhatsappConversation
    {
        $conversation = $this->findOwnedConversation($crmUserId, $conversationId);

        $next = ($conversation->status ?: 'open') === 'resolved' ? 'open' : 'resolved';
        $conversation->status = $next;
        $conversation->resolved_at = $next === 'resolved' ? Carbon::now() : null;
        $conversation->save();

        return $conversation;
    }

    public function listChatTags(int $crmUserId, string $search = ''): Collection
    {
        $query = WhatsappChatTag::query()
            ->where('crm_user_id', $crmUserId)
            ->orderBy('name');

        $search = trim($search);
        if ($search !== '') {
            $query->where('name', 'like', '%'.$search.'%');
        }

        return $query->get(['id', 'name', 'color']);
    }

    public function createChatTag(int $crmUserId, string $name, ?string $color = null): WhatsappChatTag
    {
        $tag = WhatsappChatTag::query()->firstOrCreate(
            ['crm_user_id' => $crmUserId, 'name' => trim($name)],
            ['color' => $color ?: null]
        );

        if ($color && ! $tag->color) {
            $tag->color = $color;
            $tag->save();
        }

        return $tag;
    }

    public function listQuickReplies(int $crmUserId, string $search = '', int $limit = 100): Collection
    {
        $limit = max(1, min($limit, 200));

        $query = WhatsappQuickReply::query()
            ->where('crm_user_id', $crmUserId)
            ->where('is_active', true)
            ->orderByDesc('id');

        $search = trim($search);
        if ($search !== '') {
            $query->where(function ($inner) use ($search): void {
                $inner->where('title', 'like', '%'.$search.'%')
                    ->orWhere('shortcut', 'like', '%'.$search.'%')
                    ->orWhere('body', 'like', '%'.$search.'%');
            });
        }

        return $query->limit($limit)->get(['id', 'title', 'shortcut', 'body', 'is_active']);
    }

    public function findOrCreateConversationByWaId(int $crmUserId, string $waId, ?int $accountId = null): WhatsappConversation
    {
        $normalized = $this->normalizeWaId($waId) ?: trim($waId);
        $contact = WhatsappContact::query()
            ->where('crm_user_id', $crmUserId)
            ->where('wa_id', $normalized)
            ->first(['name']);

        $conversation = WhatsappConversation::query()->firstOrCreate(
            [
                'crm_user_id' => $crmUserId,
                'wa_id' => $normalized,
                'whatsapp_business_setting_id' => $accountId,
            ],
            [
                'display_name' => $contact?->name,
                'last_message_at' => now(),
            ]
        );

        if ($contact?->name && ! $conversation->display_name) {
            $conversation->display_name = $contact->name;
        }

        if (! $conversation->last_message_at) {
            $conversation->last_message_at = now();
        }

        if ($conversation->isDirty()) {
            $conversation->save();
        }

        return $conversation;
    }

    public function findOwnedMessage(int $crmUserId, int $messageId): ?WhatsappMessage
    {
        return WhatsappMessage::query()
            ->where('crm_user_id', $crmUserId)
            ->find($messageId);
    }

    /**
     * @return array{body: string, content_type: string, filename: string}
     */
    public function messageMediaPayload(int $crmUserId, int $messageId): array
    {
        $message = $this->findOwnedMessage($crmUserId, $messageId);
        abort_if($message === null, 404);

        $raw = is_array($message->raw) ? $message->raw : [];
        $localDisk = data_get($raw, 'local_media_disk');
        $localPath = data_get($raw, 'local_media_path');

        if (is_string($localDisk) && $localDisk !== '' && is_string($localPath) && $localPath !== '') {
            try {
                $disk = Storage::disk($localDisk);
                if ($disk->exists($localPath)) {
                    return [
                        'body' => $disk->get($localPath),
                        'content_type' => (string) (data_get($raw, 'local_media_mime') ?: 'application/octet-stream'),
                        'filename' => basename($localPath),
                    ];
                }
            } catch (\Throwable) {
            }
        }

        $settingId = $message->whatsapp_business_setting_id
            ?: $message->conversation()->value('whatsapp_business_setting_id');
        abort_if(! $settingId, 404);

        $setting = WhatsappBusinessSetting::query()
            ->where('crm_user_id', $crmUserId)
            ->where('id', $settingId)
            ->where('is_active', true)
            ->first();
        abort_if($setting === null || ! $setting->api_version || ! $setting->access_token, 404);

        $mediaId = $this->extractMediaIdFromMessage($message);
        abort_if(! $mediaId, 404);

        $info = $this->repository->getMediaInfo(
            (string) $setting->api_version,
            (string) $setting->access_token,
            (string) $mediaId
        );
        $url = (string) data_get($info, 'url', '');
        abort_if($url === '', 404);

        $body = $this->repository->downloadMedia((string) $setting->access_token, $url);
        abort_if($body === '', 404);

        return [
            'body' => $body,
            'content_type' => (string) (data_get($info, 'mime_type') ?: 'application/octet-stream'),
            'filename' => 'media-'.$message->id,
        ];
    }

    protected function findOwnedConversation(int $crmUserId, int $conversationId): WhatsappConversation
    {
        $conversation = WhatsappConversation::query()
            ->where('crm_user_id', $crmUserId)
            ->find($conversationId);

        abort_if($conversation === null, 404);

        return $conversation;
    }

    protected function extractMediaIdFromMessage(WhatsappMessage $message): ?string
    {
        $raw = is_array($message->raw) ? $message->raw : [];
        $type = strtolower(trim((string) ($message->type ?? '')));

        $candidates = [
            data_get($raw, $type.'.id'),
            data_get($raw, 'media_id'),
            data_get($raw, 'uploaded_media_id'),
            data_get($raw, 'image.id'),
            data_get($raw, 'video.id'),
            data_get($raw, 'audio.id'),
            data_get($raw, 'document.id'),
            data_get($raw, 'sticker.id'),
        ];

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && trim($candidate) !== '') {
                return trim($candidate);
            }
        }

        return null;
    }

    protected function maskValue(?string $value, int $visible = 4): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);
        if ($value === '') {
            return '';
        }

        $length = mb_strlen($value);
        if ($length <= $visible) {
            return str_repeat('*', $length);
        }

        return str_repeat('*', $length - $visible).mb_substr($value, $length - $visible);
    }

    protected function normalizeWaId(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        return preg_replace('/\D+/', '', trim($value)) ?? '';
    }
}
