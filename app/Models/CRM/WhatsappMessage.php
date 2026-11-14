<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $conversation_id
 * @property int $crm_user_id
 * @property int|null $whatsapp_business_setting_id
 * @property string|null $wamid
 * @property string $direction
 * @property string|null $from_wa_id
 * @property string|null $to_wa_id
 * @property string $type
 * @property string|null $message_status
 * @property string|null $body
 * @property Carbon|null $wa_timestamp
 * @property array|null $raw
 */
class WhatsappMessage extends Model
{
    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'conversation_id',
        'crm_user_id',
        'whatsapp_business_setting_id',
        'wamid',
        'direction',
        'from_wa_id',
        'to_wa_id',
        'type',
        'message_status',
        'body',
        'wa_timestamp',
        'raw',
    ];

    protected $casts = [
        'wa_timestamp' => 'datetime',
        'raw' => 'array',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(WhatsappConversation::class, 'conversation_id');
    }

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
