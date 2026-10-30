<?php

namespace App\Models\Sanad;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientReview extends Model
{
    use HasFactory, Translatable;

    protected $table = 'client_reviews';

    protected $fillable = [];

    public $translatedAttributes = ['name', 'job', 'company_name', 'review_message'];

    protected $translationForeignKey = 'client_review_id';

    public $translationModel = ClientReviewTranslation::class;
}
