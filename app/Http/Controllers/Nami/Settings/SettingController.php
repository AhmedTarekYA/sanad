<?php

namespace App\Http\Controllers\Nami\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Nami\SettingService as ObjService;
use App\Http\Requests\Nami\Settings\StoreSettingRequest;

class SettingController extends Controller
{
    public string $folderPath = "nami.setting";
    public array $postData = ['logo_header','logo_footer','favicon','twitter','facebook','instagram','snapchat','linkedin',
        'youtube','whatsapp','email','phone','other_phone','map_link',
        'location:ar','location:en', 'footer_text:ar', 'footer_text:en',
        'website_name:ar','website_name:en',];
    public string $mainRoute = "settings";

    public function index(Request $request, ObjService $service)
    {
        $data["settings"] = $service->first();
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("auth.admins");
        $data["addButtonText"] = __("auth.admin");
        $data["modalType"] = "";

        return view($this->folderPath . '.index', $data);
    }

    public function create(Request $request)
    {

    }

    public function store(StoreSettingRequest $request, ObjService $service)
    {
        $data = $request->validated();
        $data = $service->store($data);
        return jsonSuccess($data, null, 201);
    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {

    }

    public function update(StoreSettingRequest $request, ObjService $service, $id)
    {
        $validData  = $request->only($this->postData);
        $data = $service->update($id,$validData);
        return jsonSuccess($data, null, 201);
    }

    public function destroy($id, ObjService $service)
    {

    }
}
