<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Folder,App\Models\Permission, App\Models\DocumentPermission, App\Models\History;
use App\Models\File;
use App\User;

use Auth, Session;

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

        $path = $folder->path();
        $data["path"] = $path;

        $pathStr = $folder->pathString();
        $data["pathStr"] = $pathStr;

        $user = User::find(Auth::user()->id);
        if (!$user)
            return redirect("auth/login");

        $folders = $folder->folders($user);
        if (count($folders) > 0)
            $data["folders"] = $folders;

        $files = $folder->files($user);
        if (count($files) > 0)
            $data["files"] = $files;

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
        $deleteLogs = [];
        $msg = "";
        $folders = $request->get("folders");
        $files = $request->get("files");

        if (count($folders) > 0) {
            foreach($folders as $folder) {
                $folder = Folder::find($folder);

                if($folder) {
                    $log = ["document_id"=>$folder->id,"name"=>$folder->name,"user_id"=>Auth::user()->id, "type"=>"delete","status"=>"success","reason"=>"Delete folder"];
                    History::store($log);

                    $folder->delete();
                    $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["Folder delete successfully!."]];
                }
            }
        }

        if (count($files) > 0) {
            foreach($files as $file) {
              $file = File::find($file);

              if ($this->hasDeletePermission($file,"delete")) {
                  $file->delete();

                  $log = ["document_id"=>$file->id,"name"=>$file->name,"user_id"=>Auth::user()->id, 
                    "type"=>"delete","status"=>"success","reason"=>"Delete File"];
                  History::store($log);

                  $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["File delete successfully!."]];
              }
              else {
                  $log = ["document_id"=>$file->id,"name"=>$file->name,"user_id"=>Auth::user()->id,                                     
                    "type"=>"delete","status"=>"failed","reason"=>"Permission not exists"];
                  array_push($log,$deleteLogs);

                  $msg = ["type"=>"alert-danger","icon"=>"fa-ban","data"=>["You don't have permission to delete file!."]];

                  History::store($log);
              }
            }
        }

        Session::flash("message",$msg);
        if ($request->has("_ajax") && $request->get("_ajax") == "true")
            return ["status" => "success"];
        else
            return back();
    }

    public function hasDeletePermission($folder,$permissionType)
    {
        if (!$folder)
            return false;
        }

        $permission = Permission::getPermission($permissionType);
        $hasPermission = false;
        $sharedFolders = DocumentPermission::where("document_id", $folder->id)
            ->where("user_id",Auth::user()->id)
            ->where("permission_id",$permission->id)
            ->first();

        if($sharedFolders){
          $hasPermission =  true;
        }

        if(Auth::user()->role == "admin")
            return true;

        if($hasPermission)
            return true;

        return false;
    }

    public function sharedFolder()
    {
        $data = [];
        $data['page']  = 'userlist';
        $data['users'] = User::sharedUserLists();

        return view('master', $data);
    }

    public function sharedUser($id)
    {
      $data = [];
      $user = User::find($id);
      $data['user'] = $user;
      $data['page']  = 'userdocuments';
      $data['documents']['files'] = User::sharedFiles($user);

      return view('master', $data);
    }

}
