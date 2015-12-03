<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Folder;
use App\User;

use Auth;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validation = Folder::validate($request->all());
        if ($validation->fails())
            return ["status" => "failure", "errors" => $validation->messages()->all()];

        $folder_data = [
            "name" => $request->name,
            "user_id" => Auth::user()->id
        ];

        if ($request->has("folder_id") && $request->get("folder_id"))
            $folder_data["parent"] = $request->get("folder_id");

        $folder = Folder::create($folder_data);

        if ($request->has("_ajax") && $request->get("_ajax") == "true") {
            if ($folder)
                return ["status" => "success", "folder" => $folder->toJson()];
            else
                return ["status" => "failure", "errors" => ["Error saving folder."]];
        }

        if (!$folder)
            return back()->with("errors", ["Error saving folder."]);

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
        return $this->viewEdit($id);
    }

    private function viewEdit($id)
    {
        $data = [];

        $folder = Folder::findOrFail($id);
        $data["folder"] = $folder;

        $user = User::find(Auth::user()->id);
        if (!$user)
            return redirect("auth/login");

        $folders = $folder->folders($user);
        if (count($folders) > 0)
            $data["folders"] = $folders;

        return view("index", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->viewEdit($id);
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

    public function bulkDestroy(Request $request)
    {
        $folders = $request->get("folders");

        if (count($folders) > 0) {
            Folder::destroy($folders);
        }

        if ($request->has("_ajax") && $request->get("_ajax") == "true")
            return ["status" => "success"];
        else
            return back();
    }
}
