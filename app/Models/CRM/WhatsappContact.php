<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property string $wa_id
 * @property string|null $name
 * @property string|null $profile_pic
 * @property string|null $email
 * @property string|null $source
 * @property string|null $note
 * @property array|null $custom_fields
 * @property Carbon|null $registered_at
 * @property Carbon|null $last_activity
 */
class WhatsappContact extends Model
{
    protected $table = 'whatsapp_contacts';

    protected $fillable = [
        'crm_user_id',
        'wa_id',
        'name',
        'profile_pic',
        'email',
        'source',
        'note',
        'custom_fields',
        'registered_at',
        'last_activity',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'registered_at' => 'datetime',
        'last_activity' => 'datetime',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappContactTag::class,
            'whatsapp_contact_tag',
            'contact_id',
            'tag_id'
        )->withTimestamps();
    }

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
