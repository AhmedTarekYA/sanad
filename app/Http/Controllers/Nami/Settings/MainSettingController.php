<?php

namespace App\Http\Controllers\Nami\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Nami\MainSettingService as ObjService;
use App\Http\Requests\Nami\Settings\MainSettingRequest as ObjRequest;

class MainSettingController extends Controller
{
    public $folderPath = "nami.setting";
    public $mainRoute = "main-settings";

    public function index(Request $request, ObjService $service)
    {
        $data["main_settings"] = $service->first();
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("auth.main_settings");
        $data["addButtonText"] = __("auth.admin");
        $data["modalType"] = "";

        return view($this->folderPath . '.main', $data);
    }

    public function create(Request $request)
    {

    }

    public function store(ObjRequest $request, ObjService $service)
    {
        $data = $request->validated();
        $data = $service->store($data);
        return jsonSuccess($data,null,201);
    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {

    }

    public function update(ObjRequest $request, ObjService $service, $id)
    {
        $validData  = $request->validated();
        $data = $service->update($id,$validData);
        return jsonSuccess($data,null,201);
    }

    public function destroy($id, ObjService $service)
    {

    }
}
