<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\WhatsappBusinessHoursRequest;
use App\Services\Sanad\WhatsappBusinessHoursService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappBusinessHoursController extends Controller
{
    public function index(WhatsappBusinessHoursService $service): View
    {
        $user = Auth::guard('crm')->user();

        return view('crm.whatsapp.business_hours', [
            'pageTitle' => __('whatsapp_business_hours'),
            'settings' => $service->getForUser($user),
        ]);
    }

    public function update(WhatsappBusinessHoursRequest $request, WhatsappBusinessHoursService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $settings = $service->updateForUser($user, $request->validated());

        return jsonSuccess(['settings' => $settings]);
    }
}
