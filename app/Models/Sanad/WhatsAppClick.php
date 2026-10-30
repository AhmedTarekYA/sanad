<?php

namespace App\Models\Sanad;

use Illuminate\Database\Eloquent\Model;

class WhatsAppClick extends Model
{
    protected $table = 'whatsapp_clicks';

    protected $fillable = ['page'];
}
