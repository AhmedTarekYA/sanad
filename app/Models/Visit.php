<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $ip
 * @property string|null $user_agent
 * @property string $device
 * @property string|null $browser
 * @property string|null $os
 * @property string|null $url
 * @property string|null $referer
 * @property string|null $session_id
 * @property bool $is_unique
 * @property string $created_at
 */
class Visit extends Model
{
    public $timestamps = false;

    protected $fillable = ['ip', 'user_agent', 'device', 'browser', 'os', 'url', 'referer', 'session_id', 'is_unique'];

    protected $casts = [
        'is_unique' => 'boolean',
        'created_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(fn ($model) => $model->created_at = now());
    }
}
