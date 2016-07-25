<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Validator;
use App\Models\DocumentPermission;
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

      if($user->role == "admin"){
        return Folder::where("parent", null)
            ->orderBy("name")
            ->get();
        }

      return $folders = Folder::where("parent", null)
          ->where("user_id", $user->id)
          //->orWhereIn("id",self::sharedFolders($user))
          ->orderBy("name")
          ->get();
    }

    public static function sharedFolders($user){
      $ids = [];
      $sharedFolderIds = DocumentPermission::select("document_id")->where("user_id",$user->id)
                  ->where("type","folder")
                  ->get();

      $sharedFolderIds = $sharedFolderIds->toArray();
      foreach ($sharedFolderIds as $id) {
        array_push($ids,$id["document_id"]);
      }
      return $ids;
    }

    public static function directoryTree($user)
    {
        $folders = Folder::where("user_id", $user->id)
            ->where("parent", NULL)
            ->get();

        $html = self::generateTree($folders, $user, true);

        return $html;
    }

    public static function generateTree($folders, $user, $first=false)
    {
        if (isset($folders) && count($folders) > 0) {
            $html = "<ul>";

            foreach ($folders as $folder) {
                $html .= '<li data-link="/folder/'.$folder->id.'">'.$folder->name;

                $child_folders = Folder::where("user_id", $user->id)
                    ->where("parent", $folder->id)
                    ->get();

                if (count($child_folders) > 0)
                    $html .= self::generateTree($child_folders, $user);

                $child_files = File::where("folder_id", $folder->id)
                    ->where("created_by", $user->id)
                    ->get();
                if (count($child_files) > 0) {
                    $html .= "<ul>";

                    foreach ($child_files as $file) {
                        $html .= '<li data-jstree=\'{"icon":"glyphicon glyphicon-leaf"}\' data-link="/folder/'.$file->folder_id.'/file/'.$file->id.'">'.$file->name.'</li>';
                    }

                    $html .= "</ul>";
                }

                $html .= "</li>";
            }

            if ($first == true) {
                $files = File::where("folder_id", NULL)
                    ->where("created_by", $user->id)
                    ->get();
                if (count($files) > 0) foreach ($files as $file) {
                    $html .= '<li data-jstree=\'{"icon":"glyphicon glyphicon-leaf"}\' data-link="/folder/0/file/'.$file->id.'">'.$file->name.'</li>';
                }
            }

            $html .= "</ul>";

            return $html;
        }
        else {
            return "";
        }
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

        return $pathStr;
    }
}
