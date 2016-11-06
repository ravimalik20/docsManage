<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Folder;
use App\Models\File;
use App\User, App\FileRequest;

use Auth, Session, Redirect;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($folder_id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($folder_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $folder_id)
    {
        $userId = Auth::user()->id;
        $admin = false;
        if($request->has("admin") && $request->admin){
          $userId = $request->created_by;
          $admin = true;
        }
        if ($folder_id != 0)
            $folder = Folder::findOrFail($folder_id);
        else
            $folder = null;

        $user = User::find($userId);

        if ($request->hasFile("file")) {
            $file = $request->file("file");

            $fileObj = File::saveUpload($file, $user, $folder,$admin, $request->description, $request->type);
        }

        if($request->has("filerequestId") && $request->filerequestId != '') {
          FileRequest::fileIsUploaded($request->filerequestId);
        }

        $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["Files has uploaded successfully!"]];
        Session::flash("message",$msg);

        return "success";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($folder_id, $id)
    {
        $data = [];
        if ($folder_id != 0) {
            $folder = Folder::findOrFail($folder_id);
            $path = $folder->path();
            $data["path"] = $path;

            $pathStr = $folder->pathString();
            $data["pathStr"] = $pathStr;
        }

        $file = File::findWithExtension($id);
        if (!$file)
            return abort(404);

        $data["file"] = $file;
        $data["folder_id"] = $folder_id;

        return view("files.file", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($folder_id, $id)
    {
        $data = [];

        if ($folder_id != 0) {
            $folder = Folder::findOrFail($folder_id);
            $path = $folder->path();
            $data["path"] = $path;

            $pathStr = $folder->pathString();
            $data["pathStr"] = $pathStr;
        }

        $file = File::findWithExtension($id);
        if (!$file)
            return abort(404);

        $data["file"] = $file;
        $data["folder_id"] = $folder_id;

        if ($file->sourceCode()) {
            $data["source_code"] = true;
            $data["content"] = file_get_contents(public_path($file->path));
        }

        return view("files.file_edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $folder_id, $id)
    {
        $file = File::find($id);
        if (!$file)
            return back();

        if ($request->has("content"))
            file_put_contents($file->path, $request->get("content"));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $folder_id, $id)
    {
        $file = File::find($id);
        if (!$file)
            return abort(404);

        $file->delete();

        if ($request->has("back") && $request->input("back") == "true")
            return back();

        if ($folder_id == 0)
            return redirect("/");
        else
            return redirect("/folder/$folder_id");
    }

    public function download($folder_id, $id)
    {
        $file = File::find($id);

        if ($file->hasPermission($file,"download") == false) {
            $msg = ["type"=>"alert-danger","icon"=>"fa-ban","data"=>["You don't have permission to download file!"]];
            Session::flash("message",$msg);

            return redirect("/folder/".$folder_id."/file/".$id);
        }
        if (!$file)
            return abort(404);

        return response()->download(public_path($file->path), $file->name);
    }

    public function content($folder_id, $id)
    {
        $file = File::findWithExtension($id);
        if (!$file)
            return abort(404);

        $file_path = "/".$file->path;
        $extension = $file->extension;

        $data["file"] = $file;
        $data["file_path"] = $file_path;
        $data["extension"] = $extension;

        if ($file->sourceCode()) {
            $data["source_code"] = true;
            $data["content"] = file_get_contents(public_path($file->path));
        }

        return view("files.file_content", $data);
    }


    public function deleteFileFolder($id, $type){
      $msg = '';
      if($type == 'file'){
        $file = File::find($id);
        $file->delete();
        $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["File has deleted successfully!"]];

      }
      else{
        $folder = Folder::find($id);
        $folder->delete();
        $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["Folder has deleted successfully!"]];

      }

      Session::flash("message",$msg);
      return back();
    }
}
