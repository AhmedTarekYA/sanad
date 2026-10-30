<?php

namespace App\Http\Controllers\Sanad\ClientReview;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\ClientReview\ClientReviewRequest as ObjRequest;
use App\Services\Sanad\ClientReviewService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ClientReviewController extends Controller
{
    public string $folderPath = 'sanad.client-reviews';

    public string $mainRoute = 'client-reviews';

    /**
     * @throws \Exception
     */
    public function index(Request $request, ObjService $service): mixed
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();

            if ($request->filled('date_from')) {
                $data->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $data->whereDate('created_at', '<=', $request->date_to);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', fn ($row) => e($row->name ?? '—'))
                ->addColumn('job', fn ($row) => e($row->job ?? '—'))
                ->addColumn('company_name', fn ($row) => e($row->company_name ?? '—'))
                ->addColumn('review_message', fn ($row) => e(Str::limit((string) $row->review_message, 100)))
                ->addColumn('actions', function ($row) {
                    $editBtn = checkIfHasPermission('client-reviews-update')
                        ? editButton(route($this->mainRoute.'.edit', $row->id), $row->name ?? '')
                        : '';
                    $deleteBtn = checkIfHasPermission('client-reviews-delete')
                        ? deleteButton(route($this->mainRoute.'.destroy', $row->id))
                        : '';

                    return $editBtn.' '.$deleteBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }

        $data['bladeTitle'] = __('auth.client_reviews');
        $data['createRoute'] = route($this->mainRoute.'.create');
        $data['dataTableRoute'] = route($this->mainRoute.'.index');
        $data['addButtonText'] = __('auth.client_review');
        $data['modalType'] = 'modal-xl';

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
        $service->storeReview($request->validated());

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
        $service->updateReview($id, $request->validated());

        return jsonSuccess();
    }

    public function destroy(int $id, ObjService $service): JsonResponse
    {
        $service->delete($id);

        return jsonSuccess();
    }
}
