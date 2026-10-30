<?php

namespace App\Http\Controllers\Sanad\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\Faq\FaqRequest as ObjRequest;
use App\Services\Sanad\FaqService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FaqController extends Controller
{
    public string $folderPath = 'sanad.faqs';

    public string $mainRoute = 'faqs';

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
                ->addColumn('question', fn ($row) => e(Str::limit((string) $row->question, 80)))
                ->addColumn('answer', fn ($row) => e(Str::limit((string) $row->answer, 100)))
                ->addColumn('sort_order', fn ($row) => $row->sort_order)
                ->addColumn('is_active', fn ($row) => $row->is_active
                    ? '<span class="badge bg-success">'.__('active').'</span>'
                    : '<span class="badge bg-danger">'.__('auth.inactive').'</span>')
                ->addColumn('actions', function ($row) {
                    $editBtn = checkIfHasPermission('faqs-update')
                        ? editButton(route($this->mainRoute.'.edit', $row->id), $row->question ?? '')
                        : '';
                    $deleteBtn = checkIfHasPermission('faqs-delete')
                        ? deleteButton(route($this->mainRoute.'.destroy', $row->id))
                        : '';

                    return $editBtn.' '.$deleteBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }

        $data['bladeTitle'] = __('auth.faqs');
        $data['createRoute'] = route($this->mainRoute.'.create');
        $data['dataTableRoute'] = route($this->mainRoute.'.index');
        $data['addButtonText'] = __('auth.faq');
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
        $service->storeFaq($request->validated());

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
        $service->updateFaq($id, $request->validated());

        return jsonSuccess();
    }

    public function destroy(int $id, ObjService $service): JsonResponse
    {
        $service->delete($id);

        return jsonSuccess();
    }
}
