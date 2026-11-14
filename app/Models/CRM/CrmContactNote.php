<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $whatsapp_contact_id
 * @property int $crm_user_id
 * @property string $note
 */
class CrmContactNote extends Model
{
    protected $table = 'crm_contact_notes';

    protected $fillable = [
        'whatsapp_contact_id',
        'crm_user_id',
        'note',
    ];

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }

    public function whatsappContact(): BelongsTo
    {
        return $this->belongsTo(WhatsappContact::class, 'whatsapp_contact_id');
    }
}
