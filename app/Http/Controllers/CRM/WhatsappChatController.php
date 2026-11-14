<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\WhatsappChatMediaRequest;
use App\Http\Requests\Sanad\CRM\WhatsappChatSendRequest;
use App\Http\Requests\Sanad\CRM\WhatsappChatTagRequest;
use App\Models\CRM\WhatsappBusinessSetting;
use App\Services\Sanad\WhatsappChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappChatController extends Controller
{
    public function index(Request $request, WhatsappChatService $service): View
    {
        $user = Auth::guard('crm')->user();

        $accounts = WhatsappBusinessSetting::query()
            ->where('crm_user_id', $user->id)
            ->orderBy('id')
            ->get(['id', 'name', 'phone_number_id', 'is_active']);

        $accountId = $request->filled('account_id') ? (int) $request->query('account_id') : null;
        $conversationId = $request->filled('conversation') ? (int) $request->query('conversation') : null;
        $waId = trim((string) $request->query('wa_id', ''));

        if ($waId !== '') {
            $conversationId = $service->findOrCreateConversationByWaId($user->id, $waId, $accountId)->id;
        }

        $conversations = $service->listConversations($user->id, [
            'limit' => 50,
            'offset' => 0,
            'status' => $request->query('status'),
            'tag_id' => $request->query('tag_id'),
            'search' => $request->query('search'),
            'account_id' => $accountId,
        ]);

        $activeConversation = null;
        $messages = collect();
        $messagesHasMore = false;
        $messagesNextBeforeId = null;

        if ($conversationId !== null) {
            $thread = $service->conversationMessages($user->id, $conversationId, null, 50);
            $activeConversation = $thread['conversation'];
            $messages = $thread['items']->sortBy('id')->values();
            $messagesHasMore = $thread['has_more'];
            $messagesNextBeforeId = $thread['next_before_id'];
        }

        return view('crm.whatsapp.chat', [
            'pageTitle' => __('whatsapp_chat'),
            'accounts' => $accounts,
            'conversations' => $conversations['items'],
            'activeConversation' => $activeConversation,
            'messages' => $messages,
            'messagesHasMore' => $messagesHasMore,
            'messagesNextBeforeId' => $messagesNextBeforeId,
            'chatTags' => $service->listChatTags($user->id),
            'quickReplies' => $service->listQuickReplies($user->id),
            'statusFilter' => $request->query('status'),
            'tagFilterId' => $request->query('tag_id'),
            'selectedAccountId' => $accountId,
        ]);
    }

    public function store(WhatsappChatSendRequest $request, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();
        $validated = $request->validated();

        $replyToWamid = trim((string) ($validated['reply_to_wamid'] ?? '')) ?: null;

        try {
            $result = $service->sendTextMessage(
                $user->id,
                $validated['to'],
                $validated['message'],
                isset($validated['account_id']) ? (int) $validated['account_id'] : null,
                $replyToWamid
            );
        } catch (\Throwable $e) {
            return jsonValid(['message' => [$e->getMessage()]], $e->getMessage());
        }

        return jsonSuccess($result, null, 201);
    }

    public function storeMedia(WhatsappChatMediaRequest $request, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();
        $validated = $request->validated();

        $file = $request->file('file');
        if (! $file || ! $file->isValid()) {
            return jsonValid(['file' => [__('whatsapp_invalid_file')]], __('whatsapp_validation_error'));
        }

        $serverMime = $file->getMimeType() ?: '';
        $clientMime = $file->getClientMimeType() ?: '';
        $mime = ($serverMime === 'video/webm' && str_starts_with($clientMime, 'audio/'))
            ? $clientMime
            : ($serverMime ?: $clientMime ?: 'application/octet-stream');

        $replyToWamid = trim((string) ($validated['reply_to_wamid'] ?? '')) ?: null;

        try {
            $result = $service->sendUploadedMediaMessage(
                $user->id,
                $validated['to'],
                (string) $file->getRealPath(),
                $mime,
                $file->getClientOriginalName() ?: ('file_'.time()),
                $validated['caption'] ?? null,
                $validated['force_type'] ?? null,
                $replyToWamid,
                isset($validated['account_id']) ? (int) $validated['account_id'] : null
            );
        } catch (\Throwable $e) {
            return jsonValid(['file' => [$e->getMessage()]], $e->getMessage());
        }

        return jsonSuccess($result, null, 201);
    }

    public function messageMedia(int $messageId, WhatsappChatService $service): Response
    {
        $user = Auth::guard('crm')->user();
        $payload = $service->messageMediaPayload($user->id, $messageId);

        return response($payload['body'], 200, [
            'Content-Type' => $payload['content_type'],
            'Cache-Control' => 'private, max-age=300',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline; filename="'.addslashes($payload['filename']).'"',
        ]);
    }

    public function destroyMessage(int $messageId, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();
        $message = $service->findOwnedMessage($user->id, $messageId);

        abort_if($message === null, 404);

        $wamid = trim((string) ($message->wamid ?? ''));
        if ($wamid === '') {
            return jsonValid(['message_id' => [__('whatsapp_invalid_message')]], __('whatsapp_validation_error'));
        }

        try {
            $result = $service->deleteMessage(
                $user->id,
                $wamid,
                $message->whatsapp_business_setting_id ? (int) $message->whatsapp_business_setting_id : null
            );
        } catch (\Throwable $e) {
            return jsonValid(['message_id' => [$e->getMessage()]], $e->getMessage());
        }

        return jsonSuccess($result);
    }

    public function conversations(Request $request, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $result = $service->listConversations($user->id, [
            'limit' => $request->query('limit', 50),
            'offset' => $request->query('offset', 0),
            'status' => $request->query('status'),
            'tag_id' => $request->query('tag_id'),
            'search' => $request->query('search'),
            'account_id' => $request->query('account_id'),
        ]);

        return jsonSuccess($result);
    }

    public function messages(Request $request, int $conversationId, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();
        $beforeId = $request->filled('before_id') ? (int) $request->query('before_id') : null;

        $thread = $service->conversationMessages(
            $user->id,
            $conversationId,
            $beforeId,
            (int) $request->query('limit', 50)
        );

        return jsonSuccess([
            'items' => $thread['items'],
            'has_more' => $thread['has_more'],
            'next_before_id' => $thread['next_before_id'],
        ]);
    }

    public function searchMessages(Request $request, int $conversationId, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        return jsonSuccess($service->searchConversationMessages(
            $user->id,
            $conversationId,
            (string) $request->query('q', ''),
            (int) $request->query('limit', 20)
        ));
    }

    public function meta(int $conversationId, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        return jsonSuccess($service->conversationMeta($user->id, $conversationId));
    }

    public function setTags(Request $request, int $conversationId, WhatsappChatService $service): JsonResponse
    {
        $validated = $request->validate([
            'tag_ids' => ['required', 'array'],
            'tag_ids.*' => ['integer'],
        ]);

        $user = Auth::guard('crm')->user();

        $tags = $service->setConversationTags($user->id, $conversationId, $validated['tag_ids']);

        return jsonSuccess(['tags' => $tags]);
    }

    public function addNote(Request $request, int $conversationId, WhatsappChatService $service): JsonResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:10000'],
        ]);

        $user = Auth::guard('crm')->user();

        $note = $service->addConversationNote($user->id, $conversationId, $validated['body']);

        return jsonSuccess(['note' => $note], null, 201);
    }

    public function resolve(int $conversationId, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $conversation = $service->toggleResolve($user->id, $conversationId);

        return jsonSuccess([
            'conversation' => [
                'id' => $conversation->id,
                'status' => $conversation->status,
                'resolved_at' => $conversation->resolved_at,
            ],
        ]);
    }

    public function tagsIndex(Request $request, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        return jsonSuccess([
            'items' => $service->listChatTags($user->id, (string) $request->query('search', '')),
        ]);
    }

    public function tagsStore(WhatsappChatTagRequest $request, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();
        $validated = $request->validated();

        $tag = $service->createChatTag(
            $user->id,
            $validated['name'],
            $validated['color'] ?? null
        );

        return jsonSuccess(['tag' => $tag], null, 201);
    }

    public function quickReplies(Request $request, WhatsappChatService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        return jsonSuccess([
            'items' => $service->listQuickReplies(
                $user->id,
                (string) $request->query('search', ''),
                (int) $request->query('limit', 100)
            ),
        ]);
    }
}
