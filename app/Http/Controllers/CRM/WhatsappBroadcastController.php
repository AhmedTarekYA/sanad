<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\WhatsappBroadcastRequest;
use App\Services\Sanad\WhatsappBroadcastService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappBroadcastController extends Controller
{
    public function index(WhatsappBroadcastService $service): View
    {
        $user = Auth::guard('crm')->user();

        return view('crm.whatsapp.broadcasts', [
            'pageTitle' => __('whatsapp_broadcasts'),
            'broadcasts' => $service->listForUser($user),
            'accounts' => $service->accountsForUser($user),
            'quickReplies' => $service->quickRepliesForUser($user),
        ]);
    }

    public function store(WhatsappBroadcastRequest $request, WhatsappBroadcastService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $broadcast = $service->storeForUser($user, $request->validated());

        return jsonSuccess(['broadcast' => $broadcast], null, 201);
    }

    public function update(WhatsappBroadcastRequest $request, int $id, WhatsappBroadcastService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $broadcast = $service->findForUser($user, $id);

        abort_if($broadcast === null, 404);

        if (in_array($broadcast->status, ['sent', 'canceled', 'sending'], true)) {
            return jsonValid(['status' => [__('whatsapp_broadcast_cannot_edit')]], __('whatsapp_validation_error'));
        }

        $broadcast = $service->updateForUser($user, $id, $request->validated());

        return jsonSuccess(['broadcast' => $broadcast]);
    }

    public function sendNow(int $id, WhatsappBroadcastService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $broadcast = $service->findForUser($user, $id);

        abort_if($broadcast === null, 404);

        if ($broadcast->status === 'canceled') {
            return jsonValid(['status' => [__('whatsapp_broadcast_canceled_cannot_send')]], __('whatsapp_validation_error'));
        }

        if ($broadcast->status === 'sending') {
            return jsonValid(['status' => [__('whatsapp_broadcast_sending_now')]], __('whatsapp_validation_error'));
        }

        $broadcast = $service->sendNowForUser($user, $id);

        return jsonSuccess(['broadcast' => $broadcast]);
    }

    public function cancel(int $id, WhatsappBroadcastService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $broadcast = $service->findForUser($user, $id);

        abort_if($broadcast === null, 404);

        if ($broadcast->status === 'sent') {
            return jsonValid(['status' => [__('whatsapp_broadcast_cannot_cancel_after_send')]], __('whatsapp_validation_error'));
        }

        $broadcast = $service->cancelForUser($user, $id);

        return jsonSuccess(['broadcast' => $broadcast]);
    }

    public function report(int $id, WhatsappBroadcastService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        return jsonSuccess($service->reportForUser($user, $id));
    }
}
