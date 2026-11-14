<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property string|null $timezone
 * @property bool $business_hours_enabled
 * @property array|null $hours
 * @property bool $away_message_enabled
 * @property string|null $away_message
 */
class WhatsappBusinessHoursSetting extends Model
{
    protected $table = 'whatsapp_business_hours_settings';

    protected $fillable = [
        'crm_user_id',
        'timezone',
        'business_hours_enabled',
        'hours',
        'away_message_enabled',
        'away_message',
    ];

    protected $casts = [
        'business_hours_enabled' => 'boolean',
        'away_message_enabled' => 'boolean',
        'hours' => 'array',
    ];

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
