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
class WhatsappContactTag extends Model
{
    protected $table = 'whatsapp_contact_tags';

    protected $fillable = [
        'crm_user_id',
        'name',
        'color',
    ];

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappContact::class,
            'whatsapp_contact_tag',
            'tag_id',
            'contact_id'
        )->withTimestamps();
    }

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
