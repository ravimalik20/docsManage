<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileRequest extends Model
{
    protected $table = "file_request";
    protected $guarded = array();

    public static function store($request)
    {
        $table = new FileRequest;

        $table->user_id = \Session::get("selected_user");
        $table->is_uploaded = false;
        $table->description = $request->description;
        $table->type = $request->type;
        $table->save();

        return true;
    }

    public static function userfilerequest($id)
    {
        $files = FileRequest::where('user_id', $id)->where('is_uploaded', 0)->get();

        return $files;
    }

    public static function fileIsUploaded ($id)
    {
        FileRequest::where('id', $id)->update(['is_uploaded'=>true]);

        return true;
    }
}
