<?php

namespace App\Repositories\Sanad;

use App\Models\Sanad\ConsultationRequest;
use App\Repositories\MainRepository;

class ConsultationRequestRepository extends MainRepository
{
    public function __construct(ConsultationRequest $model)
    {
        $this->model = $model;
        $this->files = [];
    }
}
