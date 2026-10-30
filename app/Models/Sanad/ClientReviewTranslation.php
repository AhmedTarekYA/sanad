<?php

namespace App\Models\Sanad;

use Illuminate\Database\Eloquent\Model;

class ClientReviewTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'client_reviews_translations';

    protected $fillable = ['name', 'job', 'company_name', 'review_message'];
}
