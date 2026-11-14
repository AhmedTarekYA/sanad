<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\WhatsappBusinessSetting;
use App\Services\Sanad\WhatsappChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class WhatsappWebhookController extends Controller
{
    public function verify(Request $request): Response
    {
        $hubMode = $request->query('hub_mode') ?? $request->query('hub.mode');
        $verifyToken = $request->query('hub_verify_token') ?? $request->query('hub.verify_token');
        $challenge = $request->query('hub_challenge') ?? $request->query('hub.challenge');

        if ($hubMode === 'subscribe' && $verifyToken !== null) {
            $matches = WhatsappBusinessSetting::query()
                ->whereNotNull('webhook_verify_token')
                ->get()
                ->contains(fn (WhatsappBusinessSetting $setting) => hash_equals(
                    (string) $setting->webhook_verify_token,
                    (string) $verifyToken
                ));

            if ($matches) {
                return response((string) $challenge, 200);
            }
        }

        abort(403);
    }

    public function receive(Request $request, WhatsappChatService $service): JsonResponse
    {
        try {
            $service->storeIncomingWebhookPayload($request->all());
        } catch (Throwable $e) {
            Log::error('whatsapp.webhook.receive.failed', [
                'error' => $e->getMessage(),
                'exception' => $e::class,
            ]);
        }

        return response()->json(['status' => 'received'], 200);
    }
}
