<?php

namespace App\Services\Sanad;

use App\Models\Sanad\Command;
use App\Services\MainService;

class CommandTerminalService extends MainService
{
    public function __construct(Command $model)
    {
        $this->model = $model;
    }
}
