<?php

namespace App\Models\Sanad;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sort_order
 * @property bool $is_active
 */
class Faq extends Model
{
    use HasFactory, Translatable;

    protected $table = 'faqs';

    protected $fillable = ['sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public $translatedAttributes = ['question', 'answer'];

    protected $translationForeignKey = 'faq_id';

    public $translationModel = FaqTranslation::class;
}
