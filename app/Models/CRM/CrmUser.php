<?php

namespace App\Models\CRM;

use Database\Factories\CrmUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $image
 * @property string $role
 * @property array|null $permissions
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
        'phone',
        'image',
        'password',
        'role',
        'permissions',
        'subscription_ends_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = [
        'image_url',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'is_active' => 'boolean',
        'role' => 'string',
        'permissions' => 'array',
    ];

    public function canAccess(string $page): bool
    {
        if ($this->role === 'admin') {
            return true;
        }

        if ($this->permissions === null) {
            return true;
        }

        return in_array($page, $this->permissions, true);
    }

    public function getImageUrlAttribute(): string
    {
        return showFile($this->image, 'admin');
    }

    public function whatsappBusinessSettings(): HasMany
    {
        return $this->hasMany(WhatsappBusinessSetting::class, 'crm_user_id');
    }

    protected static function newFactory(): CrmUserFactory
    {
        return CrmUserFactory::new();
    }
}
