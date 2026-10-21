<?php

namespace App\Services\Sanad;

use App\Services\MainService;
use App\Models\Sanad\Setting;

class SettingService extends MainService
{
    public function __construct(Setting $model)
    {
        $this->model = $model;
        $this->fileFolder = 'images/setting/';
        $this->files = ['logo_header','logo_footer','favicon'];
    }
}
