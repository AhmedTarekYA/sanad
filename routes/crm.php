<?php

use App\Http\Controllers\CRM\CrmAuthController;
use App\Http\Controllers\CRM\CrmDashboardController;
use App\Http\Controllers\CRM\WhatsappBusinessSettingController;
use App\Http\Controllers\CRM\WhatsappWebhookController;
use App\Http\Middleware\SetCrmLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.crm_domain'))->name('crm.')->middleware(SetCrmLocale::class)->group(function (): void {
    Route::get('/lang/{locale}', function (Request $request, string $locale) {
        abort_unless(array_key_exists($locale, config('laravellocalization.supportedLocales', [])), 404);

        $request->session()->put('crm_locale', $locale);

        return redirect()->back(302, [], '/');
    })->name('lang');

    Route::middleware('guest:crm')->group(function (): void {
        Route::get('/login', [CrmAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [CrmAuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('auth:crm')->group(function (): void {
        Route::get('/', [CrmDashboardController::class, 'index'])->name('dashboard');

        Route::get('/whatsapp-business-settings', [WhatsappBusinessSettingController::class, 'index'])->name('whatsapp_business_settings');
        Route::post('/whatsapp-business-settings', [WhatsappBusinessSettingController::class, 'store'])->name('whatsapp_business_settings.store');
        Route::put('/whatsapp-business-settings/{id}', [WhatsappBusinessSettingController::class, 'update'])->name('whatsapp_business_settings.update');
        Route::delete('/whatsapp-business-settings/{id}', [WhatsappBusinessSettingController::class, 'destroy'])->name('whatsapp_business_settings.destroy');
        Route::get('/whatsapp-setup', [CrmDashboardController::class, 'setup'])->name('whatsapp_setup');
        Route::get('/whatsapp-chat', [CrmDashboardController::class, 'chat'])->name('whatsapp_chat');
        Route::get('/whatsapp-broadcasts', [CrmDashboardController::class, 'broadcasts'])->name('whatsapp_broadcasts');
        Route::get('/whatsapp-contacts', [CrmDashboardController::class, 'contacts'])->name('whatsapp_contacts');
        Route::get('/whatsapp-labels', [CrmDashboardController::class, 'labels'])->name('whatsapp_labels');
        Route::get('/whatsapp-quick-replies', [CrmDashboardController::class, 'quickReplies'])->name('whatsapp_quick_replies');
        Route::get('/whatsapp-business-hours', [CrmDashboardController::class, 'businessHours'])->name('whatsapp_business_hours');
        Route::get('/whatsapp-analytics', [CrmDashboardController::class, 'analytics'])->name('whatsapp_analytics');

        Route::post('/logout', [CrmAuthController::class, 'logout'])->name('logout');
    });

    Route::get('/whatsapp/webhook', [WhatsappWebhookController::class, 'verify'])->name('whatsapp.webhook.verify');
    Route::post('/whatsapp/webhook', [WhatsappWebhookController::class, 'receive'])->name('whatsapp.webhook.receive');
});
