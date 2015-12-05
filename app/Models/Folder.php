<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Folder extends Model
{
    protected $table = 'folders';

    protected $fillable = ['name', 'user_id', 'parent'];

    public static function validate($input)
    {
        $rules = [
            "name" => "required|string",
        ];

        return Validator::make($input, $rules);
    }

    public static function rootFolders($user)
    {
        $folders = Folder::where("parent", null)
            ->where("user_id", $user->id)
            ->orderBy("name")
            ->get();

        return $folders;
    }

    public function folders($user)
    {
        $folders = Folder::where("parent", $this->id)
            ->where("user_id", $user->id)
            ->orderBy("name")
            ->get();

        return $folders;
    }

    public function files($user)
    {
        $files = File::where("folder_id", $this->id)
            ->where("created_by", $user->id)
            ->orderBy("name")
            ->get();

        return $files;
    }

    public function path()
    {
        $path = [Folder::find($this->id)];

        $folder_id = $this->parent;
        while ($folder_id) {
            $folder = Folder::find($folder_id);
            array_push($path, $folder);

            $folder_id = $folder->parent;
        }

        return array_reverse($path);
    }

    public function pathString()
    {
        $path = $this->path();
        $pathStr = "/";

        foreach ($path as $p) {
            $pathStr.= $p->name."/";
        }

        //echo $pathStr; die;

        return $pathStr;
    }
}
