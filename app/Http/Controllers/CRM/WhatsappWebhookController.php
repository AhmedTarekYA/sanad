<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\WhatsappBusinessSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function receive(Request $request): JsonResponse
    {
        // TODO: real message handling later.
        return response()->json(['status' => 'received'], 200);
    }
}
