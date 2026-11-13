<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ConsultationStoreRequest;
use App\Services\Sanad\ConsultationRequestService;
use Illuminate\Http\JsonResponse;

class ConsultationController extends Controller
{
    public function store(ConsultationStoreRequest $request, ConsultationRequestService $service): JsonResponse
    {
        $service->storeConsultationRequest($request->validated());

        return response()->json([
            'code' => 200,
            'message' => __('auth.consultation_sent_success'),
        ]);
    }
}
