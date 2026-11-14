<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $crm_user_id
 * @property string|null $customer_name
 * @property string|null $phone
 * @property string|null $request_text
 * @property float|string|null $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class CrmSale extends Model
{
    protected $table = 'crm_sales';

    protected $fillable = [
        'crm_user_id',
        'customer_name',
        'phone',
        'request_text',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function crmUser(): BelongsTo
    {
        return $this->belongsTo(CrmUser::class, 'crm_user_id');
    }
}
