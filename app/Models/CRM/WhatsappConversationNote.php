<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $conversation_id
 * @property int $crm_user_id
 * @property string $body
 */
class WhatsappConversationNote extends Model
{
    protected $table = 'whatsapp_conversation_notes';

    protected $fillable = [
        'conversation_id',
        'crm_user_id',
        'body',
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
