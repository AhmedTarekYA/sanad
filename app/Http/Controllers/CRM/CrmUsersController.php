<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\CRM\CrmUserRequest;
use App\Services\CRM\CrmUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CrmUsersController extends Controller
{
    public const PERMISSION_PAGES = [
        'whatsapp_business_settings',
        'whatsapp_setup',
        'whatsapp_chat',
        'whatsapp_broadcasts',
        'whatsapp_contacts',
        'whatsapp_labels',
        'whatsapp_quick_replies',
        'whatsapp_business_hours',
        'whatsapp_analytics',
        'crm_sales',
    ];

    public function index(Request $request, CrmUsersService $service): View|JsonResponse
    {
        abort_unless(Auth::guard('crm')->user()?->role === 'admin', 403);

        if ($request->ajax() || $request->wantsJson()) {
            return jsonSuccess(['items' => $service->listUsers()]);
        }

        return view('crm.users.index', [
            'pageTitle' => __('users'),
        ]);
    }

    public function create(): View
    {
        return view('crm.users.create', [
            'pageTitle' => __('users'),
            'permissionPages' => self::PERMISSION_PAGES,
        ]);
    }

    public function store(CrmUserRequest $request, CrmUsersService $service): JsonResponse
    {
        $user = $service->storeUser($request->validated());

        return jsonSuccess([
            'user' => $user,
            'url' => route('crm.users.index'),
        ], null, 201);
    }

    public function edit(int $id, CrmUsersService $service): View
    {
        return view('crm.users.edit', [
            'pageTitle' => __('users'),
            'user' => $service->find($id),
            'permissionPages' => self::PERMISSION_PAGES,
        ]);
    }

    public function update(CrmUserRequest $request, int $id, CrmUsersService $service): JsonResponse
    {
        $user = $service->updateUser($id, $request->validated());

        return jsonSuccess([
            'user' => $user,
            'url' => route('crm.users.index'),
        ]);
    }

    public function destroy(int $id, CrmUsersService $service): JsonResponse
    {
        $user = $service->find($id);
        abort_if($user === null, 404);
        abort_if($user->id === Auth::guard('crm')->id(), 422);

        $service->deleteWithFile($id, 'image');

        return jsonSuccess();
    }
}
