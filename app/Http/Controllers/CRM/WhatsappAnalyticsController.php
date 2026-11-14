<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Services\Sanad\WhatsappAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappAnalyticsController extends Controller
{
    public function index(Request $request, WhatsappAnalyticsService $service): View|JsonResponse
    {
        $days = (int) $request->query('days', 30);

        if (! in_array($days, [7, 30, 90], true)) {
            $days = 30;
        }

        $user = Auth::guard('crm')->user();
        $data = $service->summaryForUser($user, $days);

        if ($request->ajax() || $request->wantsJson()) {
            return jsonSuccess($data);
        }

        return view('crm.whatsapp.analytics', array_merge($data, [
            'pageTitle' => __('whatsapp_analytics'),
        ]));
    }
}
