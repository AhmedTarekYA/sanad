<?php

namespace App\Models\Projectconfig;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property boolean $is_dev
 * @property boolean $is_maintenance
 * @property boolean $force_update
 * @property boolean $show_dialog
 * @property string $latest_version_android
 * @property string $latest_version_ios
 * @property string $api_base_url
 * @property string $api_image_base_url
 * @property boolean $enable_payment
 * @property string $welcome_message
 * @property string $update_message
 * @property string $maintenance_message
 * @property string $force_update_message
 * @property string $maps_api_key
 * @property string $created_at
 * @property string $updated_at
 */
class Config extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['is_dev', 'is_maintenance', 'force_update', 'show_dialog', 'latest_version_android', 'latest_version_ios', 'api_base_url', 'api_image_base_url', 'enable_payment', 'welcome_message', 'update_message', 'maintenance_message', 'force_update_message', 'maps_api_key', 'created_at', 'updated_at'];
}
