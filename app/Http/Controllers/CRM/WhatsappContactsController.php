<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\WhatsappContactImportRequest;
use App\Http\Requests\Sanad\CRM\WhatsappContactRequest;
use App\Http\Requests\Sanad\CRM\WhatsappContactTagRequest;
use App\Services\Sanad\WhatsappContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WhatsappContactsController extends Controller
{
    public function index(Request $request, WhatsappContactService $service): View|JsonResponse
    {
        $user = Auth::guard('crm')->user();

        if ($request->ajax() || $request->wantsJson()) {
            $contacts = $service->listForUser($user, [
                'search' => $request->query('search'),
                'tag_ids' => $request->query('tag_ids', []),
                'limit' => $request->query('limit', 25),
            ]);

            return jsonSuccess([
                'items' => $contacts->items(),
                'pagination' => [
                    'current_page' => $contacts->currentPage(),
                    'per_page' => $contacts->perPage(),
                    'next_page_url' => $contacts->nextPageUrl(),
                    'previous_page_url' => $contacts->previousPageUrl(),
                ],
            ]);
        }

        return view('crm.whatsapp.contacts', [
            'pageTitle' => __('whatsapp_contacts'),
            'contactTags' => $service->contactTagsForUser($user),
        ]);
    }

    public function show(int $id, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        return jsonSuccess($service->detailsForUser($user, $id));
    }

    public function store(WhatsappContactRequest $request, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $contact = $service->storeForUser($user, $request->validated());

        return jsonSuccess(['contact' => $contact], null, 201);
    }

    public function update(WhatsappContactRequest $request, int $id, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $contact = $service->updateForUser($user, $id, $request->validated());

        return jsonSuccess(['contact' => $contact]);
    }

    public function destroy(int $id, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        if (! $service->deleteForUser($user, $id)) {
            abort(404);
        }

        return jsonSuccess();
    }

    public function setTags(Request $request, int $id, WhatsappContactService $service): JsonResponse
    {
        $validated = $request->validate([
            'tag_ids' => ['required', 'array'],
            'tag_ids.*' => ['integer'],
        ]);

        $user = Auth::guard('crm')->user();
        $contact = $service->findForUser($user, $id);

        abort_if($contact === null, 404);

        $contact = $service->syncTags($user, $contact, $validated['tag_ids']);

        return jsonSuccess(['contact' => $contact]);
    }

    public function import(WhatsappContactImportRequest $request, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $result = $service->importForUser($user, $request->file('file')->getRealPath());

        return jsonSuccess($result, null, 201);
    }

    public function contactTagsIndex(WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        return jsonSuccess(['items' => $service->contactTagsForUser($user)]);
    }

    public function contactTagsStore(WhatsappContactTagRequest $request, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $tag = $service->storeTagForUser($user, $request->validated());

        return jsonSuccess(['tag' => $tag], null, 201);
    }

    public function contactTagsUpdate(WhatsappContactTagRequest $request, int $id, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        $tag = $service->updateTagForUser($user, $id, $request->validated());

        return jsonSuccess(['tag' => $tag]);
    }

    public function contactTagsDestroy(int $id, WhatsappContactService $service): JsonResponse
    {
        $user = Auth::guard('crm')->user();

        if (! $service->deleteTagForUser($user, $id)) {
            abort(404);
        }

        return jsonSuccess();
    }
}
