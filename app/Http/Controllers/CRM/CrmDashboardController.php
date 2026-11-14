<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
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

    public function setup(): View
    {
        return $this->placeholder('whatsapp_setup');
    }

    public function chat(): View
    {
        return $this->placeholder('whatsapp_chat');
    }

    public function broadcasts(): View
    {
        return $this->placeholder('whatsapp_broadcasts');
    }

    public function contacts(): View
    {
        return $this->placeholder('whatsapp_contacts');
    }

    public function labels(): View
    {
        return $this->placeholder('whatsapp_labels');
    }

    public function quickReplies(): View
    {
        return $this->placeholder('whatsapp_quick_replies');
    }

    public function businessHours(): View
    {
        return $this->placeholder('whatsapp_business_hours');
    }

    public function analytics(): View
    {
        return $this->placeholder('whatsapp_analytics');
    }

    private function placeholder(string $titleKey): View
    {
        return view('crm.pages.placeholder', [
            'pageTitle' => __($titleKey),
        ]);
    }
}
