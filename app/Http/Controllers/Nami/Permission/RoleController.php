<?php

namespace App\Http\Controllers\Nami\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Services\Nami\RoleService as ObjService;
use App\Http\Requests\Nami\Permission\RoleRequest as ObjRequest;


class RoleController extends Controller
{
    public $folderPath = "nami.permission.roles";
    public $mainRoute = "roles";

    public function index(Request $request, ObjService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $id = $row->id;
                    $url = route('roles.edit', $row->id);
                    $canEdit = checkIfHasPermission('roles-update'); //Auth::guard('admin')->user()->hasPermission('roles-update', 'admin');
                    $editButton = $canEdit
                        ? '<a href="' . route($this->mainRoute . ".edit", $row->id) . '" class="btn btn-primary shadow btn-xs sharp me-1" title="' . __('admin.edit') . '" data-id="' . $id . '">
                            <i class="fa fa-pencil"></i>
                            </a>'
                        : '';
                    $canDelete = checkIfHasPermission('roles-delete'); //Auth::guard('admin')->user()->hasPermission('roles-delete', 'admin');
                    $deleteButton = $canDelete
                        ? deleteButton(route($this->mainRoute . ".destroy", $row->id))
                        : '';
                    return $editButton . $deleteButton;
                })
                ->escapeColumns([])->make(true);
        }
        $data['oneObjectTitle'] = __('permission.role');
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("permission.roles");
        $data["addButtonText"] = __("permission.role");
       $data["modalType"] = "";
        return view($this->folderPath . '.index', $data);
    }

    public function create(ObjService $service)
    {
        $data["permissions"] = $service->getPermissions();
        $data["bladeTitle"] = __("permission.add role");
        return view($this->folderPath . '.create', $data);
    }

    public function store(ObjRequest $request, ObjService $service)
    {
        $service->storeRole($request->validated());
        return response()->json([
            'code' => 200,
            'message' => __("auth.done successfully"),
            'url' => route('roles.index'),
        ]);
    }

    public function edit($id, ObjService $service)
    {
        $data['role'] = $service->find($id);
        $data['rolePermissions'] = $service->getRolePermissions($id);
        $data["permissions"] = $service->getPermissions();
        $data["bladeTitle"] = __("permission.edit role");
        return view($this->folderPath . '.edit', $data);
    }

    public function update(ObjRequest $request, $id, ObjService $service)
    {
        $service->updateRole($id,$request->validated());
        return response()->json([
            'code' => 200,
            'message' => __("auth.done successfully"),
            'url' => route('roles.index')
        ]);
    }


    public function destroy($id, ObjService $service)
    {
        $service->deleteWithFile($id,'image');
        return jsonSuccess();
    }
}
