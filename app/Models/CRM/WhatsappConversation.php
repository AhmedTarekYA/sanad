<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property int|null $whatsapp_business_setting_id
 * @property string $wa_id
 * @property string|null $display_name
 * @property string $status
 * @property Carbon|null $resolved_at
 * @property Carbon|null $last_message_at
 * @property int $unread_count
 */
class WhatsappConversation extends Model
{
    protected $table = 'whatsapp_conversations';

    protected $fillable = [
        'crm_user_id',
        'whatsapp_business_setting_id',
        'wa_id',
        'display_name',
        'status',
        'resolved_at',
        'last_message_at',
        'unread_count',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'resolved_at' => 'datetime',
        'unread_count' => 'integer',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(WhatsappMessage::class, 'conversation_id');
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(WhatsappMessage::class, 'conversation_id')->latestOfMany();
    }

    public function whatsappBusinessSetting(): BelongsTo
    {
        return $this->belongsTo(WhatsappBusinessSetting::class, 'whatsapp_business_setting_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappChatTag::class,
            'whatsapp_conversation_tag',
            'conversation_id',
            'tag_id'
        )->withTimestamps();
    }

    public function notes(): HasMany
    {
        return $this->hasMany(WhatsappConversationNote::class, 'conversation_id');
    }

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
