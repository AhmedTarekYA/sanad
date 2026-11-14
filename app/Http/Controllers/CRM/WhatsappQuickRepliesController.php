<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\WhatsappQuickReplyRequest;
use App\Services\Sanad\WhatsappQuickReplyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappQuickRepliesController extends Controller
{
    public function index(WhatsappQuickReplyService $service): View
    {
        $user = Auth::guard('crm')->user();

        return view('crm.whatsapp.quick_replies', [
            'pageTitle' => __('whatsapp_quick_replies'),
            'items' => $service->allForUser($user),
        ]);
    }

    public function store(WhatsappQuickReplyRequest $request, WhatsappQuickReplyService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $item = $service->storeForUser($user, $request->validated());

        return jsonSuccess(['item' => $item], null, 201);
    }

    public function update(WhatsappQuickReplyRequest $request, int $id, WhatsappQuickReplyService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $item = $service->updateForUser($user, $id, $request->validated());

        return jsonSuccess(['item' => $item]);
    }

    public function destroy(int $id, WhatsappQuickReplyService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        if (! $service->deleteForUser($user, $id)) {
            abort(404);
        }

        return jsonSuccess();
    }
}
