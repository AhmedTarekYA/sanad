<?php

namespace App\Services\Nami;

use App\Models\Nami\MainSetting;
use App\Services\MainService;

class MainSettingService extends MainService
{
    public function __construct(MainSetting $model)
    {
        $this->model = $model;
        $this->fileFolder = 'images/mainSetting/';
        $this->files = ['footer_logo'];
    }
}
