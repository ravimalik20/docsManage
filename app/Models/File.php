<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentPermission, App\Models\Permission, App\Models\History;
use Validator, Auth;
use App\Email,App\Setting, App\FileTag, App\Tag;
class File extends Model
{
    protected $table = 'files';

    protected $fillable = ['name', 'extension_id', 'path', "folder_id",
        "created_by", "uploaded_by", "description", "type"];

    public static function validate($input)
    {
        $rules = [
            "name" => "required|string",
        ];

        return Validator::make($input, $rules);
    }

    public static function findWithExtension($id)
    {
        $file = File::select("files.*", "extensions.name as extension")
            ->join("extensions", "files.extension_id", "=", "extensions.id")
            ->where("files.id", $id)
            ->first();

        return $file;
    }

    public static function saveUpload($file, $user, $folder=null, $admin=false, $description=null, $type=null)
    {
        $uploaded_by = null;
        $filename = htmlspecialchars($file->getClientOriginalName());
        $extension = htmlspecialchars($file->getClientOriginalExtension());
        if($admin)
        {
          $uploaded_by = Auth::user()->id;
        }
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
            "created_by" => $user->id,
            "uploaded_by" => $uploaded_by,
            "description" => $description,
            "type" => $type
        ];

        if ($folder != null)
            $data["folder_id"] = $folder->id;

        $obj = File::create($data);
        self::setPermissions($obj);

        $log = ["document_id"=>$obj->id,"user_id"=>$user->id,
          "type"=>"upload","status"=>"success","reason"=>"","uploaded_by"=>$uploaded_by];
        History::store($log);

        if(Setting::emailSetting($user,"file_upload")){
            $user->subject = "New File Uploaded";
            $user->body = "A new file, '".$filename."', has been uploaded to your account.";
            Email::fileUpload($user);
        }
        return $obj;
    }

    public static function setPermissions($obj){
      $permissions = Permission::all();
      foreach($permissions as $getper){
        $permission = DocumentPermission::firstOrNew(array("user_id"=>$obj->created_by,"document_id"=>$obj->id,"permission_id"=>$getper->id));
        $permission->user_id = $obj->created_by;
        $permission->document_id = $obj->id;
        $permission->type = "file";
        $permission->permission_id = $getper->id;
        $permission->save();
      }
      return 1;
    }

    public static function rootFiles($user)
    {

        if($user->role == "admin"){
          return File::where("folder_id", null)
              ->orderBy("name")
              ->get();
        }
        return $files = File::where("folder_id", null)
            ->Where("created_by", $user->id)
            //->OrWhereIn("id",self::sharedFiles($user))
            ->orderBy("name")
            ->get();
    }

    public static function sharedFiles($user){
      $ids = [];
      $sharedFolderIds = DocumentPermission::select("document_id")->where("user_id",$user->id)
                  ->where("type","file")
                  ->get();

      if(count($sharedFolderIds)>0){
        $sharedFolderIds = $sharedFolderIds->toArray();
        foreach ($sharedFolderIds as $id) {
          array_push($ids,$id["document_id"]);
        }
      }
      return $ids;
    }

    public function sourceCode()
    {
        $source_extensions = [
            "php", "c", "cpp", "java", "py", "rb", "pl", "html", "css", "js",
            "diff", "json", "md", "make", "sh", "xml", "sql",
        ];

        $extension = $this->extension;

        if (in_array($extension, $source_extensions))
            return true;
        else
            return false;
    }

    public function language()
    {
        $language = [
            "php" => "php", "c" => "c_cpp", "cpp" => "c_cpp", "java" => "java",
            "py" => "python", "rb" => "ruby", "pl" => "perl", "html" => "html",
            "css" => "css", "js" => "javascript", "diff" => "diff",
            "json" => "json", "md" => "markdown", "make" => "makefile",
            "sh" => "sh", "xml" => "xml", "sql" => "sql",
        ];

        if (isset($this->extension)) {
            $ext = $this->extension;
        }
        else {
            $extension = Extension::find($this->extension_id);
            $ext = $extension->name;
        }

        if (array_key_exists($ext, $language))
            return $language[$ext];
        else
            return null;
    }

    public function hasPermission($folder,$permissionType)
    {
        $permission = Permission::getPermission($permissionType);
        $sharedFolders = DocumentPermission::where("document_id", $folder->id)
                        ->where("user_id",Auth::user()->id)
                        ->where("permission_id",$permission->id)
                        ->first();

        if ($sharedFolders) {
            return true;
        }

        if (\App\Models\Permission::canManage(\Auth::user()->id, $folder->created_by)) {
            return true;
        }

        if (Auth::user()->role == "admin")
            return true;

        return false;
    }

    public function getFolderIdAttribute($val)
    {
        return $val ? $val : 0;
    }

    public function tags()
    {
      return Tag::select('tags.name')
          ->join('file_tags','file_tags.tag_id','=', 'tags.id')
          ->where('file_tags.file_id', $this->id)
          ->lists('tags.name')
          ->toArray();

    }
}
