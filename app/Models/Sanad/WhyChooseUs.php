<?php

namespace App\Models\Sanad;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property bool $is_featured
 * @property int $sort_order
 */
class WhyChooseUs extends Model
{
    use HasFactory, Translatable;

    protected $table = 'why_choose_us';

    protected $fillable = ['is_featured', 'sort_order'];

    protected $casts = ['is_featured' => 'boolean'];

    public $translatedAttributes = ['title', 'subtitle'];

    protected $translationForeignKey = 'why_choose_us_id';

    public $translationModel = WhyChooseUsTranslation::class;

    public function features(): HasMany
    {
        return $this->hasMany(WhyChooseUsFeature::class, 'why_choose_us_id')->orderBy('sort_order');
    }
}
