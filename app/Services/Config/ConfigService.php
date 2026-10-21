<?php

namespace App\Services\Config;

use App\Services\MainService;
use App\Models\Config\Config;

class ConfigService extends MainService
{
    public function __construct(Config $model)
    {
        $this->model = $model;
        $this->fileFolder = 'images/Config/';
        // pass the files that want to save
        $this->files = ['image'];
    }

    public function getDataByName($data)
    {
        return $this->model->where('name', $data['name'])->first();
    }

    public function formatConfig(Config $config): array
    {
        
        return [
            "app_mode" => [
                "is_dev" => (bool) $config->is_dev,
                "is_maintenance" => (bool) $config->is_maintenance,
                "force_update" => (bool) $config->force_update,
                "show_dialog" => (bool) $config->show_dialog,
            ],
            "update" => [
                "latest_version_android" => $config->latest_version_android,
                "latest_version_ios" => $config->latest_version_ios,
            ],
            "api" => [
                "base_url" => $config->api_base_url,
                "image_base_url" => $config->api_image_base_url,
            ],
            "features" => [
                "enable_payment" => (bool) $config->enable_payment,
            ],
            "messages" => [
                "welcomeMessage" => $config->welcome_message,
                "updateMessage" => $config->update_message,
                "maintenanceMessage" => $config->maintenance_message,
                "forceUpdateMessage" => $config->force_update_message,
            ],
            "integrations" => [
                "mapsApiKey" => $config->maps_api_key,
            ],
        ];
    }
}