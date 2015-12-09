<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Folder;
use App\Models\File;
use App\User;

use Auth;

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
        if ($folder_id != 0)
            $folder = Folder::findOrFail($folder_id);
        else
            $folder = null;

        $user = User::find(Auth::user()->id);

        if ($request->hasFile("file")) {
            $file = $request->file("file");

            $fileObj = File::saveUpload($file, $user, $folder);
        }

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
        return $this->viewEdit($folder_id, $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($folder_id, $id)
    {
        return $this->viewEdit($folder_id, $id);
    }

    private function viewEdit($folder_id, $id)
    {
        $data = [];

        if ($folder_id != 0) {
            $folder = Folder::findOrFail($folder_id);
            $path = $folder->path();
            $data["path"] = $path;
        }

        $file = File::findWithExtension($id);
        if (!$file)
            return abort(404);

        $data["file"] = $file;
        $data["folder_id"] = $folder_id;

        return view("files.file", $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder, $id)
    {
        //
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

        return view("files.file_content", $data);
    }
}
