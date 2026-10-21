<?php

namespace App\Http\Controllers\Sanad\Authentication;

use App\Enums\AdminTypeisEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sanad\Admin\AdminRequest as ObjRequest;
use App\Services\Sanad\AdminService as ObjService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public string $folderPath = 'sanad.admin';

    public string $mainRoute = 'admins';

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|JsonResponse|\Illuminate\View\View
     *
     * @throws Exception
     */
    public function index(Request $request, ObjService $service)
    {
        if ($request->ajax()) {
            $dataTable = $service->getDataTable()->where('admin_type', '!=', AdminTypeisEnum::Developer->value);

            return DataTables::of($dataTable)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $src = showFile($row->image, 'admin');

                    return '<img src="'.e($src).'" alt="'.e($row->name).'" class="admin-table-avatar">';
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('phone', function ($row) {
                    return $row->phone;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('actions', function ($row) {
                    $deleteButton = '';
                    $editButton = editButton(route($this->mainRoute.'.edit', $row->id), $row->name);
                    if ($row->id != Auth::guard('admin')->user()->id) {
                        $deleteButton = deleteButton(route($this->mainRoute.'.destroy', $row->id));
                    }

                    return $editButton.' '.$deleteButton;
                })->rawColumns(['actions', 'image'])->make(true);
        }
        $data['createRoute'] = route($this->mainRoute.'.create');
        $data['dataTableRoute'] = route($this->mainRoute.'.index');
        $data['bladeTitle'] = __('auth.admins');
        $data['addButtonText'] = __('auth.admin');

        return view($this->folderPath.'.index', $data);
    }

    /**
     * @return JsonResponse|void
     *
     * @throws Throwable
     */
    public function create(Request $request, ObjService $service)
    {
        if ($request->ajax()) {
            $models = ['users', 'settings'];
            $maps = ['1' => 'create', '2' => 'read', '3' => 'update', '4' => 'delete'];
            $returnHTML = view($this->folderPath.'.create')->with([
                'models' => $models,
                'maps' => $maps,
                'storeRoute' => route($this->mainRoute.'.store'),
                'roles' => $service->getRoles(),
            ])->render();

            return jsonSuccess(['html' => $returnHTML]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(ObjRequest $request, ObjService $service)
    {
        $dataInsert = $request->validated();
        $data = $service->storeAdmin($dataInsert);

        return jsonSuccess($data);
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return JsonResponse|void
     *
     * @throws Throwable
     */
    public function edit(int $id, Request $request, ObjService $service)
    {
        if ($request->ajax()) {
            $models = ['users', 'settings'];
            $maps = ['1' => 'create', '2' => 'read', '3' => 'update', '4' => 'delete'];
            $returnHTML = view($this->folderPath.'.edit')->with([
                'obj' => $service->find($id),
                'models' => $models,
                'maps' => $maps,
                'roles' => $service->getRoles(),
                'updateRoute' => route($this->mainRoute.'.update', $id),
            ])->render();

            return jsonSuccess(['html' => $returnHTML]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function update(ObjRequest $request, int $id, ObjService $service)
    {
        $dataInsert = $request->validated();
        $data = $service->updateAdmin($id, $dataInsert);

        return jsonSuccess($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(int $id, ObjService $service)
    {
        $service->delete($id);

        return jsonSuccess();
    }
}
