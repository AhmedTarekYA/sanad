<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Sanad\ConsultationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'mobile_whatsapp' => ['required', 'string', 'max:255'],
            'daily_contact_volume' => ['required', 'string', 'max:255'],
            'current_systems' => ['nullable', 'string', 'max:500'],
        ]);

        ConsultationRequest::create($validated);

        return response()->json([
            'code' => 200,
            'message' => __('auth.consultation_sent_success'),
        ]);
    }
}
