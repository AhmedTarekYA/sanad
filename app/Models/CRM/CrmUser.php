<?php

namespace App\Models\CRM;

use Database\Factories\CrmUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon|null $subscription_ends_at
 * @property bool $is_active
 */
class CrmUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'crm_users';

    protected $guard = 'crm';

    protected $fillable = [
        'name',
        'email',
        'password',
        'subscription_ends_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function newFactory(): CrmUserFactory
    {
        return CrmUserFactory::new();
    }
}
