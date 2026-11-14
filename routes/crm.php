<?php

use App\Http\Controllers\CRM\CrmAuthController;
use App\Http\Controllers\CRM\CrmDashboardController;
use Illuminate\Support\Facades\Route;

Route::domain('crm.sanadcx.com')->name('crm.')->group(function (): void {
    Route::middleware('guest:crm')->group(function (): void {
        Route::get('/login', [CrmAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [CrmAuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('auth:crm')->group(function (): void {
        Route::get('/', [CrmDashboardController::class, 'index'])->name('dashboard');

        Route::get('/whatsapp-business-settings', [CrmDashboardController::class, 'businessSettings'])->name('whatsapp_business_settings');
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
});
