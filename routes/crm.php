<?php

use App\Http\Controllers\CRM\CrmAuthController;
use App\Http\Controllers\CRM\CrmDashboardController;
use App\Http\Controllers\CRM\WhatsappAnalyticsController;
use App\Http\Controllers\CRM\WhatsappBroadcastController;
use App\Http\Controllers\CRM\WhatsappBusinessHoursController;
use App\Http\Controllers\CRM\WhatsappBusinessSettingController;
use App\Http\Controllers\CRM\WhatsappChatController;
use App\Http\Controllers\CRM\WhatsappContactsController;
use App\Http\Controllers\CRM\WhatsappLabelsController;
use App\Http\Controllers\CRM\WhatsappQuickRepliesController;
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
        Route::get('/whatsapp-chat', [WhatsappChatController::class, 'index'])->name('whatsapp_chat');
        Route::post('/whatsapp-chat', [WhatsappChatController::class, 'store'])->name('whatsapp_chat.store');
        Route::post('/whatsapp-chat/media', [WhatsappChatController::class, 'storeMedia'])->name('whatsapp_chat.media');
        Route::get('/whatsapp-chat/messages/{messageId}/media', [WhatsappChatController::class, 'messageMedia'])->name('whatsapp_chat.messageMedia');
        Route::delete('/whatsapp-chat/messages/{messageId}', [WhatsappChatController::class, 'destroyMessage'])->name('whatsapp_chat.messages.delete');
        Route::get('/whatsapp-chat/conversations', [WhatsappChatController::class, 'conversations'])->name('whatsapp_chat.conversations');
        Route::get('/whatsapp-chat/conversations/{conversationId}/messages', [WhatsappChatController::class, 'messages'])->name('whatsapp_chat.messages');
        Route::get('/whatsapp-chat/conversations/{conversationId}/search', [WhatsappChatController::class, 'searchMessages'])->name('whatsapp_chat.messages.search');
        Route::get('/whatsapp-chat/conversations/{conversationId}/meta', [WhatsappChatController::class, 'meta'])->name('whatsapp_chat.meta');
        Route::put('/whatsapp-chat/conversations/{conversationId}/tags', [WhatsappChatController::class, 'setTags'])->name('whatsapp_chat.tags.set');
        Route::post('/whatsapp-chat/conversations/{conversationId}/notes', [WhatsappChatController::class, 'addNote'])->name('whatsapp_chat.notes.store');
        Route::put('/whatsapp-chat/conversations/{conversationId}/resolve', [WhatsappChatController::class, 'resolve'])->name('whatsapp_chat.resolve');
        Route::get('/whatsapp-chat/tags', [WhatsappChatController::class, 'tagsIndex'])->name('whatsapp_chat.tags.index');
        Route::post('/whatsapp-chat/tags', [WhatsappChatController::class, 'tagsStore'])->name('whatsapp_chat.tags.store');
        Route::get('/whatsapp-chat/quick-replies', [WhatsappChatController::class, 'quickReplies'])->name('whatsapp_chat.quickReplies');
        Route::get('/whatsapp-broadcasts', [WhatsappBroadcastController::class, 'index'])->name('whatsapp_broadcasts');
        Route::post('/whatsapp-broadcasts', [WhatsappBroadcastController::class, 'store'])->name('whatsapp_broadcasts.store');
        Route::put('/whatsapp-broadcasts/{id}', [WhatsappBroadcastController::class, 'update'])->name('whatsapp_broadcasts.update');
        Route::post('/whatsapp-broadcasts/{id}/send-now', [WhatsappBroadcastController::class, 'sendNow'])->name('whatsapp_broadcasts.send_now');
        Route::post('/whatsapp-broadcasts/{id}/cancel', [WhatsappBroadcastController::class, 'cancel'])->name('whatsapp_broadcasts.cancel');
        Route::get('/whatsapp-broadcasts/{id}/report', [WhatsappBroadcastController::class, 'report'])->name('whatsapp_broadcasts.report');
        Route::get('/whatsapp-contacts', [WhatsappContactsController::class, 'index'])->name('whatsapp_contacts');
        Route::post('/whatsapp-contacts/import', [WhatsappContactsController::class, 'import'])->name('whatsapp_contacts.import');
        Route::post('/whatsapp-contacts', [WhatsappContactsController::class, 'store'])->name('whatsapp_contacts.store');
        Route::get('/whatsapp-contacts/{id}', [WhatsappContactsController::class, 'show'])->name('whatsapp_contacts.show');
        Route::put('/whatsapp-contacts/{id}', [WhatsappContactsController::class, 'update'])->name('whatsapp_contacts.update');
        Route::put('/whatsapp-contacts/{id}/tags', [WhatsappContactsController::class, 'setTags'])->name('whatsapp_contacts.tags.set');
        Route::delete('/whatsapp-contacts/{id}', [WhatsappContactsController::class, 'destroy'])->name('whatsapp_contacts.destroy');
        Route::get('/whatsapp-contact-tags', [WhatsappContactsController::class, 'contactTagsIndex'])->name('contact_tags.index');
        Route::post('/whatsapp-contact-tags', [WhatsappContactsController::class, 'contactTagsStore'])->name('contact_tags.store');
        Route::put('/whatsapp-contact-tags/{id}', [WhatsappContactsController::class, 'contactTagsUpdate'])->name('contact_tags.update');
        Route::delete('/whatsapp-contact-tags/{id}', [WhatsappContactsController::class, 'contactTagsDestroy'])->name('contact_tags.destroy');
        Route::get('/whatsapp-labels', [WhatsappLabelsController::class, 'index'])->name('whatsapp_labels');
        Route::post('/whatsapp-labels', [WhatsappLabelsController::class, 'store'])->name('whatsapp_labels.store');
        Route::put('/whatsapp-labels/{id}', [WhatsappLabelsController::class, 'update'])->name('whatsapp_labels.update');
        Route::delete('/whatsapp-labels/{id}', [WhatsappLabelsController::class, 'destroy'])->name('whatsapp_labels.destroy');
        Route::get('/whatsapp-quick-replies', [WhatsappQuickRepliesController::class, 'index'])->name('whatsapp_quick_replies');
        Route::post('/whatsapp-quick-replies', [WhatsappQuickRepliesController::class, 'store'])->name('whatsapp_quick_replies.store');
        Route::put('/whatsapp-quick-replies/{id}', [WhatsappQuickRepliesController::class, 'update'])->name('whatsapp_quick_replies.update');
        Route::delete('/whatsapp-quick-replies/{id}', [WhatsappQuickRepliesController::class, 'destroy'])->name('whatsapp_quick_replies.destroy');
        Route::get('/whatsapp-business-hours', [WhatsappBusinessHoursController::class, 'index'])->name('whatsapp_business_hours');
        Route::put('/whatsapp-business-hours', [WhatsappBusinessHoursController::class, 'update'])->name('whatsapp_business_hours.update');
        Route::get('/whatsapp-analytics', [WhatsappAnalyticsController::class, 'index'])->name('whatsapp_analytics');

        Route::post('/logout', [CrmAuthController::class, 'logout'])->name('logout');
    });

    Route::get('/whatsapp/webhook', [WhatsappWebhookController::class, 'verify'])->name('whatsapp.webhook.verify');
    Route::post('/whatsapp/webhook', [WhatsappWebhookController::class, 'receive'])->name('whatsapp.webhook.receive');
});
