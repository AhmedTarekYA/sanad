<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Services\Sanad\WhatsappBusinessSettingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CrmDashboardController extends Controller
{
    public function index(): View
    {
        return view('crm.dashboard', [
            'pageTitle' => __('auth.dashboard'),
        ]);
    }

    public function businessSettings(): View
    {
        return $this->placeholder('whatsapp_business_settings');
    }

    public function setup(WhatsappBusinessSettingService $service): View
    {
        $user = Auth::guard('crm')->user();
        $settings = $service->getPrimaryForUser($user);

        return view('crm.whatsapp.setup', [
            'pageTitle' => __('whatsapp_setup'),
            'settings' => $settings,
            'webhookUrl' => route('crm.whatsapp.webhook.receive'),
            'verifyUrl' => route('crm.whatsapp.webhook.verify'),
            'hasActive' => (bool) $service->allForUser($user)->contains('is_active', true),
            'hasRequired' => $settings && $settings->api_version && $settings->phone_number_id && $settings->access_token,
            'metaAppsUrl' => 'https://developers.facebook.com/apps/',
        ]);
    }

    private function placeholder(string $titleKey): View
    {
        return view('crm.pages.placeholder', [
            'pageTitle' => __($titleKey),
        ]);
    }
}
