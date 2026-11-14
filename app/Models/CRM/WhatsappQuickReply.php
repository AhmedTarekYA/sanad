<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property string $title
 * @property string|null $shortcut
 * @property string $body
 * @property bool $is_active
 */
class WhatsappQuickReply extends Model
{
    protected $table = 'whatsapp_quick_replies';

    protected $fillable = [
        'crm_user_id',
        'title',
        'shortcut',
        'body',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
