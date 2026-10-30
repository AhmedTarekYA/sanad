<?php

namespace App\Http\Controllers\Sanad\WhyChooseUs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\WhyChooseUs\WhyChooseUsRequest as ObjRequest;
use App\Services\Sanad\WhyChooseUsService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WhyChooseUsController extends Controller
{
    public string $folderPath = 'sanad.why-choose-us';

    public string $mainRoute = 'why-choose-us';

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
                ->addColumn('title', fn ($row) => e($row->title ?? '—'))
                ->addColumn('subtitle', fn ($row) => e($row->subtitle ?? '—'))
                ->addColumn('features', function ($row) {
                    if ($row->features->isEmpty()) {
                        return '<span class="text-muted">—</span>';
                    }

                    $badges = $row->features
                        ->map(fn ($feature) => '<span class="badge bg-light-primary me-1 mb-1">'.e($feature->title ?? '—').'</span>')
                        ->implode('');

                    return '<span class="badge bg-dark me-1 mb-1">'.$row->features->count().'</span>'.$badges;
                })
                ->addColumn('actions', function ($row) {
                    $editBtn = checkIfHasPermission('why-choose-us-update')
                        ? editButton(route($this->mainRoute.'.edit', $row->id), $row->title ?? '')
                        : '';
                    $deleteBtn = checkIfHasPermission('why-choose-us-delete')
                        ? deleteButton(route($this->mainRoute.'.destroy', $row->id))
                        : '';

                    return $editBtn.' '.$deleteBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }

        $data['bladeTitle'] = __('auth.why_choose_us');
        $data['createRoute'] = route($this->mainRoute.'.create');
        $data['dataTableRoute'] = route($this->mainRoute.'.index');
        $data['addButtonText'] = __('auth.why_choose_us_item');
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
        $service->storeCard($request->validated());

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
        $service->updateCard($id, $request->validated());

        return jsonSuccess();
    }

    public function destroy(int $id, ObjService $service): JsonResponse
    {
        $service->delete($id);

        return jsonSuccess();
    }
}
