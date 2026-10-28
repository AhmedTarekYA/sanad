<?php

namespace App\Services\Sanad;

use App\Models\Sanad\ConsultationRequest;
use App\Services\MainService;

class ConsultationRequestService extends MainService
{
    public function __construct(ConsultationRequest $model)
    {
        $this->model = $model;
        $this->files = [];
    }
}
