<?php

namespace App\Models\Sanad;

use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    protected $fillable = [
        'full_name',
        'company_name',
        'mobile_whatsapp',
        'daily_contact_volume',
        'current_systems',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
