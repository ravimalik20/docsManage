<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Auth;
use App\Models\Folder,App\Models\File, App\Models\DocumentPermission;
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function lists(){
      return User::where("id","!=",Auth::user()->id)->get();
    }

    public static function documents($user,$folderID){
      $data = [];
      $folder = Folder::find($folderID);
      if($folder){
        return self::folderDocuments($user,$folder);
      }
      return self::rootDocuments($user);
    }

    public static function rootDocuments($user){
      $data = [];
      $folders = Folder::rootFolders($user);
      if (count($folders) > 0)
          $data["folders"] = $folders;

      $files = File::rootFiles($user);
      if (count($files) > 0)
          $data["files"] = $files;
    return $data;
    }

    public static function folderDocuments($user,$folder){
      $data = [];
      $folders = $folder->folders($user);
      if (count($folders) > 0)
          $data["folders"] = $folders;

      $files = $folder->files($user);
      if (count($files) > 0)
          $data["files"] = $files;

      return $data;
    }

    public static function sharedFiles($user){
      $sharedFileIds = self::sharedFilesIds($user);
      $files = File::whereIn("id",$sharedFileIds)
          ->orderBy("name")
          ->get();
      return $files;
    }

    public static function sharedFilesIds($user){
      $ids = [];
      $sharedFolderIds = DocumentPermission::select("files.id")
                  ->join("users","users.id","=","document_permission.user_id")
                  ->join("files","document_permission.document_id","=","files.id")
                  ->where("document_permission.user_id",Auth::user()->id)
                  ->where("type","file")
                  ->where("files.created_by","!=",Auth::user()->id)
                  ->where("files.created_by",$user->id)
                  ->distinct()
                  ->get();
      if(count($sharedFolderIds)>0){
        $sharedFolderIds = $sharedFolderIds->toArray();
        foreach ($sharedFolderIds as $id) {
          array_push($ids,$id["id"]);
        }
      }
      return $ids;
    }

    public static function sharedUserLists(){
      $sharedFolderIds = self::sharedUserIds();
      return User::whereIn("id",$sharedFolderIds)->get();
    }

    public static function sharedUserIds(){
      $ids = [];
      $sharedFolderIds = DocumentPermission::select("files.created_by")
                  ->join("users","users.id","=","document_permission.user_id")
                  ->join("files","document_permission.document_id","=","files.id")
                  ->where("document_permission.user_id",Auth::user()->id)
                  ->where("files.created_by","!=",Auth::user()->id)
                  ->where("type","file")
                  ->distinct()
                  ->get();
      if(count($sharedFolderIds)>0){
        $sharedFolderIds = $sharedFolderIds->toArray();
        foreach ($sharedFolderIds as $id) {
          array_push($ids,$id["created_by"]);
        }
      }
      return $ids;
    }
}
