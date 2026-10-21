<?php

namespace App\Models\Nami;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $setting_id
 * @property string $locale
 * @property string $location
 * @property string $copyright
 * @property string $website_name
 * @property string $privacy
 * @property string $created_at
 * @property string $updated_at
 * @property Setting $setting
 */
class SettingsTranslation extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */


    /**
     * @var array
     */
    protected $fillable = ['setting_id', 'locale', 'location', 'copyright', 'website_name', 'footer_text',
                            'privacy', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
