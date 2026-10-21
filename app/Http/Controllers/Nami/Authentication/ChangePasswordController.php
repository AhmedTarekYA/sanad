<?php

namespace App\Http\Controllers\Nami\Authentication;

use App\Services\Nami\AdminService as ObjAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Nami\Authentication\CahngePasswordRequest  as UpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class ChangePasswordController extends Controller
{

    public $folderPath = "admin.auth.profile";
    public $mainRoute = "profile";
    public $postData = ["password"];

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, ObjAction $action)
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

    public function store(/*StoreRequest $request,*/ ObjAction $action)
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

    public function edit($id, Request $request, ObjAction $action)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateRequest $request,$id,ObjAction $action)
    {
        $admin = $action->find($id);
        if(!password_verify($request->current_password, $admin->password)){
            return jsonValid(['error' => [__('auth.current_password_not_match')]],'');
        }
        $action->update($id,['password'=> $request->new_password]);
        return jsonSuccess('','تم تغير كلمه المرور بنجاح',201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ObjAction $action)
    {

    }

}
