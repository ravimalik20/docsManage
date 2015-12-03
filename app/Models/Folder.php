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
}
