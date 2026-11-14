<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property int|null $whatsapp_business_setting_id
 * @property string $title
 * @property string $type
 * @property string|null $message_body
 * @property string|null $template_name
 * @property string|null $template_language
 * @property array|null $button_quick_reply_ids
 * @property Carbon|null $scheduled_at
 * @property string $status
 * @property Carbon|null $sent_at
 * @property int $audience_count
 * @property int $delivered_count
 * @property int $failed_count
 */
class WhatsappBroadcast extends Model
{
    protected $table = 'whatsapp_broadcasts';

    protected $fillable = [
        'crm_user_id',
        'whatsapp_business_setting_id',
        'title',
        'type',
        'message_body',
        'template_name',
        'template_language',
        'button_quick_reply_ids',
        'scheduled_at',
        'status',
        'sent_at',
        'audience_count',
        'delivered_count',
        'failed_count',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'button_quick_reply_ids' => 'array',
        'audience_count' => 'integer',
        'delivered_count' => 'integer',
        'failed_count' => 'integer',
    ];

    public function recipients(): HasMany
    {
        return $this->hasMany(WhatsappBroadcastRecipient::class, 'broadcast_id');
    }

    public function whatsappBusinessSetting(): BelongsTo
    {
        return $this->belongsTo(WhatsappBusinessSetting::class, 'whatsapp_business_setting_id');
    }

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
