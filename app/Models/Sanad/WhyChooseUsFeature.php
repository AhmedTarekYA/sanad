<?php

namespace App\Models\Sanad;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $why_choose_us_id
 * @property int $sort_order
 */
class WhyChooseUsFeature extends Model
{
    use HasFactory, Translatable;

    protected $table = 'why_choose_us_features';

    protected $fillable = ['sort_order'];

    public $translatedAttributes = ['title', 'description'];

    protected $translationForeignKey = 'why_choose_us_feature_id';

    public $translationModel = WhyChooseUsFeatureTranslation::class;

    public function whyChooseUs(): BelongsTo
    {
        return $this->belongsTo(WhyChooseUs::class, 'why_choose_us_id');
    }
}
