<?php

namespace App\Http\Controllers\Sanad\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\Blog\BlogRequest as ObjRequest;
use App\Services\Sanad\BlogService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    public string $folderPath = 'sanad.blog';

    public string $mainRoute = 'blogs';

    /**
     * @throws \Exception
     */
    public function index(Request $request, ObjService $service): mixed
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="'.showFile($row->image).'" style="width:48px;height:48px;object-fit:cover;border-radius:6px;" alt="">';
                })
                ->addColumn('title', fn ($row) => e($row->title ?? '—'))
                ->addColumn('actions', function ($row) {
                    $editBtn = checkIfHasPermission('blogs-update')
                        ? editButton(route($this->mainRoute.'.edit', $row->id), $row->title ?? '')
                        : '';
                    $deleteBtn = checkIfHasPermission('blogs-delete')
                        ? deleteButton(route($this->mainRoute.'.destroy', $row->id))
                        : '';

                    return $editBtn.' '.$deleteBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }

        $data['bladeTitle'] = __('auth.blogs');
        $data['createRoute'] = route($this->mainRoute.'.create');
        $data['dataTableRoute'] = route($this->mainRoute.'.index');
        $data['addButtonText'] = __('auth.blog');
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
        $data = $service->storeBlog($request->validated());

        return jsonSuccess($data);
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
        $service->updateBlog($id, $request->validated());

        return jsonSuccess(null);
    }

    public function destroy(int $id, ObjService $service): JsonResponse
    {
        $service->deleteWithFile($id, 'image');

        return jsonSuccess();
    }
}
