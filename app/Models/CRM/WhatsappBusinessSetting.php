<?php

namespace App\Models\CRM;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property string|null $name
 * @property bool $is_active
 * @property string|null $api_version
 * @property string|null $phone_number_id
 * @property string|null $business_account_id
 * @property string|null $access_token
 * @property string|null $webhook_verify_token
 * @property string|null $app_secret
 */
class WhatsappBusinessSetting extends Model
{
    protected $table = 'whatsapp_business_settings';

    protected $fillable = [
        'crm_user_id',
        'name',
        'is_active',
        'api_version',
        'phone_number_id',
        'business_account_id',
        'access_token',
        'webhook_verify_token',
        'app_secret',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }

    protected function safeDecrypt(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        try {
            return Crypt::decryptString($value);
        } catch (DecryptException) {
            return $value;
        }
    }

    public function getAccessTokenAttribute(?string $value): ?string
    {
        return $this->safeDecrypt($value);
    }

    public function setAccessTokenAttribute(?string $value): void
    {
        $this->attributes['access_token'] = $value !== null && $value !== '' ? Crypt::encryptString($value) : null;
    }

    public function getWebhookVerifyTokenAttribute(?string $value): ?string
    {
        return $this->safeDecrypt($value);
    }

    public function setWebhookVerifyTokenAttribute(?string $value): void
    {
        $this->attributes['webhook_verify_token'] = $value !== null && $value !== '' ? Crypt::encryptString($value) : null;
    }

    public function getAppSecretAttribute(?string $value): ?string
    {
        return $this->safeDecrypt($value);
    }

    public function setAppSecretAttribute(?string $value): void
    {
        $this->attributes['app_secret'] = $value !== null && $value !== '' ? Crypt::encryptString($value) : null;
    }
}
