<?php

namespace App\Models\Sanad;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $logo_header
 * @property string $logo_footer
 * @property string $favicon
 * @property string $twitter
 * @property string $facebook
 * @property string $instagram
 * @property string $snapchat
 * @property string $linkedin
 * @property string $youtube
 * @property string $whatsapp
 * @property string $email
 * @property string $phone
 * @property string $other_phone
 * @property string $map_link
 * @property string $created_at
 * @property string $updated_at
 * @property SettingsTranslation[] $settingsTranslations
 */

class Setting extends Model
{
    use Translatable, HasFactory;
    protected $with = ['translations'];
    protected $translationForeignKey = 'setting_id';
    public $translationModel = SettingsTranslation::class;


    protected $fillable = ['logo_header', 'logo_footer', 'favicon', 'twitter', 'facebook', 'instagram', 'snapchat', 'linkedin', 'youtube', 'whatsapp', 'email', 'phone', 'other_phone', 'map_link', 'created_at', 'updated_at'];

    public $translatedAttributes = ['location', 'privacy', 'rights_maids', 'rights_users', 'copyright', 'website_name',
        'about_us_sub_title', 'footer_text','terms_conditions', 'work_times', 'about_us_app'];


    public function settingsTranslations()
    {
        return $this->hasMany('App\Models\project\SettingsTranslation');
    }
}
