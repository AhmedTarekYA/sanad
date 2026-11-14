<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $broadcast_id
 * @property string $wa_id
 * @property string|null $wamid
 * @property string $status
 * @property string|null $error
 * @property Carbon|null $sent_at
 * @property Carbon|null $delivered_at
 */
class WhatsappBroadcastRecipient extends Model
{
    protected $table = 'whatsapp_broadcast_recipients';

    protected $fillable = [
        'broadcast_id',
        'wa_id',
        'wamid',
        'status',
        'error',
        'sent_at',
        'delivered_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function broadcast(): BelongsTo
    {
        return $this->belongsTo(WhatsappBroadcast::class, 'broadcast_id');
    }
}
