<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Validator;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = ['name', 'extension_id', 'path', "folder_id", "created_by"];

    public static function validate($input)
    {
        $rules = [
            "name" => "required|string",
        ];

        return Validator::make($input, $rules);
    }

    public static function saveUpload($file, $user, $folder=null)
    {
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $ext = Extension::firstOrCreate([
            "name" => strtolower($extension)
        ]);

        $path = "fileuploads/";
        $uploaded_file_name = str_random("10").$filename;

        $upload_path = $path.$uploaded_file_name;

        $file->move(public_path($path), $uploaded_file_name);

        $data = [
            "name" => $filename,
            "extension_id" => $ext->id,
            "path" => $upload_path,
            "created_by" => $user->id
        ];

        if ($folder != null)
            $data["folder_id"] = $folder->id;

        $obj = File::create($data);
        return $obj;
    }

    public static function rootFiles($user)
    {
        $files = File::where("folder_id", null)
            ->where("created_by", $user->id)
            ->orderBy("name")
            ->get();

        return $files;
    }
}
