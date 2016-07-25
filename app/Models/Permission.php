<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permissions";
    protected $guarded = array();

    public static function getPermissionIds($type=false){
      $ids = [];
      if($type == false)
      {
        $permissions = Permission::all();
      }else{
        $permissions = Permission::where("name",$type)->get();
      }

      foreach($permissions as $permission){
        array_push($ids, $permission->id);
      }
      return $ids;
    }

      public static function getPermission($permission){
      return Permission::where("name",$permission)->first();
    }
}
