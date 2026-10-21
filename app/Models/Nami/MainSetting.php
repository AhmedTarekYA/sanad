<?php

namespace App\Models\Nami;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $loading_background_color
 */

class MainSetting extends Model
{
    use Translatable, HasFactory;
    protected $with = ['translations'];
    protected $translationForeignKey = 'main_setting_id';
    public $translationModel = MainSettingTranslation::class;

    protected $fillable = ['loading_background_color', 'footer_logo', 'copyright_link', 'link'];

    public $translatedAttributes = ['sidebar_text', 'copyright_text', 'company_name'];


}
