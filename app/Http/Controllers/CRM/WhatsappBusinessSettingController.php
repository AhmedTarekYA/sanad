<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\WhatsappBusinessSettingRequest;
use App\Services\Sanad\WhatsappBusinessSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappBusinessSettingController extends Controller
{
    public function index(WhatsappBusinessSettingService $service): View
    {
        $user = Auth::guard('crm')->user();

        return view('crm.whatsapp.business_settings', [
            'pageTitle' => __('whatsapp_business_settings'),
            'whatsapp_settings' => $service->allForUser($user),
        ]);
    }

    public function store(WhatsappBusinessSettingRequest $request, WhatsappBusinessSettingService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $service->syncAccountsForUser($user, $request->validated()['accounts'] ?? []);

        return jsonSuccess($service->allForUser($user), null, 201);
    }

    public function update(WhatsappBusinessSettingRequest $request, int $id, WhatsappBusinessSettingService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        if ($request->has('accounts')) {
            $service->syncAccountsForUser($user, $request->validated()['accounts'] ?? []);
        } else {
            $setting = $service->allForUser($user)->firstWhere('id', $id);

            abort_if($setting === null, 404);

            $service->updateAccountForUser($user, $setting, $request->validated());
        }

        return jsonSuccess($service->allForUser($user), null, 201);
    }

    public function destroy(int $id, WhatsappBusinessSettingService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        if (! $service->deleteForUser($user, $id)) {
            abort(404);
        }

        return jsonSuccess();
    }
}
