<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\WhatsappLabelRequest;
use App\Services\Sanad\WhatsappLabelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappLabelsController extends Controller
{
    public function index(WhatsappLabelService $service): View
    {
        $user = Auth::guard('crm')->user();

        return view('crm.whatsapp.labels', [
            'pageTitle' => __('whatsapp_labels'),
            'contactTags' => $service->contactTagsForUser($user),
            'chatTags' => $service->chatTagsForUser($user),
        ]);
    }

    public function store(WhatsappLabelRequest $request, WhatsappLabelService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();
        $validated = $request->validated();
        $scope = $validated['scope'];

        $tag = $service->storeForUser($user, $scope, $validated);

        return jsonSuccess(['tag' => $tag, 'scope' => $scope], null, 201);
    }

    public function update(WhatsappLabelRequest $request, int $id, WhatsappLabelService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();
        $validated = $request->validated();
        $scope = $validated['scope'];

        $tag = $service->updateForUser($user, $scope, $id, $validated);

        return jsonSuccess(['tag' => $tag, 'scope' => $scope]);
    }

    public function destroy(Request $request, int $id, WhatsappLabelService $service): JsonResponse
    {
        $scope = trim((string) $request->input('scope', ''));

        if (! in_array($scope, ['contact', 'chat'], true)) {
            return jsonValid(['scope' => [__('whatsapp_invalid_scope')]], __('whatsapp_validation_error'));
        }

        $user = Auth::guard('crm')->user();

        if (! $service->deleteForUser($user, $scope, $id)) {
            abort(404);
        }

        return jsonSuccess();
    }
}
