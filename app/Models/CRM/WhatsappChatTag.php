<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property string $name
 * @property string|null $color
 */
class WhatsappChatTag extends Model
{
    protected $table = 'whatsapp_chat_tags';

    protected $fillable = [
        'crm_user_id',
        'name',
        'color',
    ];

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappConversation::class,
            'whatsapp_conversation_tag',
            'tag_id',
            'conversation_id'
        )->withTimestamps();
    }

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
