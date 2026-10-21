<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
 use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use App\Services\Config\ConfigService as objService;
use App\Http\Requests\Config\ConfigRequest as objRequest;

class ConfigController extends Controller
{
    public string $folderPath = "config.configs";
    public string $mainRoute = "configs";

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $dataTable = $service->getDataTable();
            return DataTables::of($dataTable)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                    $showButton = '';
                    $addPlus = '' ;
                    $editButton = editButton(route($this->mainRoute . ".edit", $row->id), $row->name);
                    $deleteButton = deleteButton(route($this->mainRoute . ".destroy", $row->id));
                    $showButton = showButton(route($this->mainRoute . ".show", $row->id));
                    $addPlus =addPlus(route('configs.create',['config_id'=>$row->id]),__("Add New Config"));

                    return $editButton . " " . $deleteButton . " " . $showButton . ' ' . $addPlus;
                })
                ->escapeColumns([])
                ->make(true);
        }

        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __('Config');
        $data["addButtonText"] = __('Config');
        return view($this->folderPath . '.index', $data);
    }

    public function create(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $returnHTML = view($this->folderPath . ".create", [
                'storeRoute' => route($this->mainRoute . ".store"),
                'obj' => $service->find($request->config_id ?? 0),
                // Pass additional data if needed
            ])->render();
            return jsonSuccess(["html" => $returnHTML]);
        }
    }

    public function store(objRequest $request, objService $service)
    {
        $dataInsert = $request->validated();
        $data = $service->store($dataInsert);
        return jsonSuccess($data);
    }

    public function show(int $id, Request $request, objService $service)
    {
        if ($request->ajax()) {
            $returnHTML = view($this->folderPath . ".show")->with([
                "obj" => $service->find($id),
            ])->render();
            return jsonSuccess(["html" => $returnHTML]);
        }
    }

    public function edit(int $id, Request $request, objService $service)
    {
        if ($request->ajax()) {
            $returnHTML = view($this->folderPath . ".edit")->with([
                'updateRoute' => route($this->mainRoute . ".update", $id),
                "obj" => $service->find($id),
            ])->render();
            return jsonSuccess(["html" => $returnHTML]);
        }
    }

    public function update(objRequest $request, int $id, objService $service)
    {
          $dataInsert = $request->validated();
        //   dd($dataInsert);
           $data = $service->update($id, $dataInsert);
         return jsonSuccess($data);
    }


/*******  561a19e2-923c-4eb6-bda5-c027a68d31f3  *******//*************  ✨ Windsurf Command ⭐  *************/

    public function destroy(int $id, objService $service)
    {
        $service->delete($id);
        return jsonSuccess();
    }
}
