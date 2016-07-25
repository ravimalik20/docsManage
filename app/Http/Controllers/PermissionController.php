<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Folder, App\Models\File, App\Models\DocumentPermission,App\User,App\Models\History,Session;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo  "here";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      DocumentPermission::store($request);

      $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["Permission added successfully!."]];
      Session::flash("message",$msg);

      return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function documentPermission(Request $request)
    {
        $users = User::lists();
        $files = [];
        $folders = [];
        $getUsersObj = [];

        if (count($request->folders) > 0)
            $folders = $request->folders;

        if (count($request->files) > 0)
            $folders = $request->files;

        $documentIds = $folders;
        $applyPermissions = $this->checkDocumentPermissions($documentIds);
        $getUserFilePermissions = [];

        foreach ($applyPermissions as $applyPermission) {
            if (array_key_exists($applyPermission->user_id,$getUserFilePermissions)){
                array_push($getUserFilePermissions[$applyPermission->user_id]["permissions"],$applyPermission->permission_id);
                continue;
            }

            $getUserFilePermissions[$applyPermission->user_id] = ["document_id"=>$applyPermission->document_id,"permissions"=>
                [$applyPermission->permission_id]];
        }

        foreach ($users as $user) {
            if(array_key_exists($user->id,$getUserFilePermissions)){
              $user->sharedFiles = $getUserFilePermissions[$user->id];
            }

            array_push($getUsersObj,$user);
        }

        return json_encode(["status"=>"success","users"=>$getUsersObj,"filepermissions"=>$applyPermissions]);
    }

    public function checkDocumentPermissions($documentIds)
    {
        return DocumentPermission::whereIn("document_id",$documentIds)->get();
    }
}
