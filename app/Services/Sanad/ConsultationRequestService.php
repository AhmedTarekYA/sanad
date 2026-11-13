<?php

namespace App\Services\Sanad;

use App\Models\Sanad\ConsultationRequest;
use App\Repositories\Sanad\ConsultationRequestRepository;
use App\Services\MainService;

class ConsultationRequestService extends MainService
{
    public function __construct(ConsultationRequest $model, private ConsultationRequestRepository $repository)
    {
        $this->model = $model;
        $this->files = [];
    }

    /** @param array<string, mixed> $data */
    public function storeConsultationRequest(array $data): ConsultationRequest
    {
        return $this->repository->store($data);
    }
}
