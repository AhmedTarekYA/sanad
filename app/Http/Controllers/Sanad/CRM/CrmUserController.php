<?php

namespace App\Http\Controllers\Sanad\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\CRM\CrmUserRequest as ObjRequest;
use App\Services\Sanad\CrmUserService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CrmUserController extends Controller
{
    public string $folderPath = 'sanad.crm-users';

    public string $mainRoute = 'crm-users';

    /**
     * @throws \Exception
     */
    public function index(Request $request, ObjService $service): mixed
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();

            if ($request->filled('status')) {
                $data->where('is_active', (bool) $request->status);
            }

            if ($request->filled('date_from')) {
                $data->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $data->whereDate('created_at', '<=', $request->date_to);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', fn ($row) => e($row->name))
                ->addColumn('email', fn ($row) => e($row->email))
                ->addColumn('subscription_ends_at', fn ($row) => $row->subscription_ends_at?->format('Y-m-d H:i') ?? '-')
                ->addColumn('is_active', fn ($row) => $row->is_active
                    ? '<span class="badge bg-success">'.__('active').'</span>'
                    : '<span class="badge bg-danger">'.__('inactive').'</span>')
                ->addColumn('actions', function ($row) {
                    $editBtn = checkIfHasPermission('crm-users-update')
                        ? editButton(route($this->mainRoute.'.edit', $row->id), $row->name ?? '')
                        : '';
                    $deleteBtn = checkIfHasPermission('crm-users-delete')
                        ? deleteButton(route($this->mainRoute.'.destroy', $row->id))
                        : '';

                    return $editBtn.' '.$deleteBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }

        $data['bladeTitle'] = __('auth.crm_users');
        $data['createRoute'] = route($this->mainRoute.'.create');
        $data['dataTableRoute'] = route($this->mainRoute.'.index');
        $data['addButtonText'] = __('auth.crm_user');
        $data['modalType'] = 'modal-lg';

        return view($this->folderPath.'.index', $data);
    }

    /**
     * @throws \Throwable
     */
    public function create(Request $request): ?JsonResponse
    {
        if ($request->ajax()) {
            $html = view($this->folderPath.'.create', [
                'storeRoute' => route($this->mainRoute.'.store'),
            ])->render();

            return jsonSuccess(['html' => $html]);
        }

        return null;
    }

    public function store(ObjRequest $request, ObjService $service): JsonResponse
    {
        $service->storeCrmUser($request->validated());

        return jsonSuccess();
    }

    /**
     * @throws \Throwable
     */
    public function edit(int $id, Request $request, ObjService $service): ?JsonResponse
    {
        if ($request->ajax()) {
            $html = view($this->folderPath.'.edit', [
                'obj' => $service->find($id),
                'updateRoute' => route($this->mainRoute.'.update', $id),
            ])->render();

            return jsonSuccess(['html' => $html]);
        }

        return null;
    }

    public function update(ObjRequest $request, int $id, ObjService $service): JsonResponse
    {
        $service->updateCrmUser($id, $request->validated());

        return jsonSuccess();
    }

    public function destroy(int $id, ObjService $service): JsonResponse
    {
        $service->delete($id);

        return jsonSuccess();
    }
}
