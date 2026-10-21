<?php

namespace App\Http\Controllers\Nami\Authentication;
use App\Http\Controllers\Controller;

use App\Services\Nami\AdminService as ObjService;

use App\Http\Requests\Nami\Authentication\UpdateProfileRequest as UpdateRequest;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public $folderPath = "nami.auth.profile";
    public $mainRoute = "profile";
    public $postData = ["name", "email", "phone", 'image'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(ObjService $service)
    {
        $data["user"] = $service->getAuthUser();
        $data["bladeTitle"] = __("auth.profile");
        return view('nami.auth.profile', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, ObjService $service)
    {
        if ($request->ajax()) {
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(/*StoreRequest $request,*/ ObjService $service)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id, Request $request, ObjService $service)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateRequest $request, $id, ObjService $service)
    {
        $dataInsert = $request->only($this->postData);
        $data = $service->update($id, $dataInsert);
        return jsonSuccess($data, 'تم تعديل البيانات بنجاح',201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ObjService $service)
    {

    }
}
