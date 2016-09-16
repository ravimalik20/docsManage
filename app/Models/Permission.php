<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Permission extends Model
{
    protected $table = "permissions";
    protected $guarded = array();

    public static function getPermissionIds($type=false)
    {
        $ids = [];
        if($type == false) {
            $permissions = Permission::all();
        }
        else {
            $permissions = Permission::where("name",$type)->get();
        }

        foreach ($permissions as $permission) {
            array_push($ids, $permission->id);
        }

        return $ids;
    }

    public static function getPermission($permission)
    {
        return Permission::where("name",$permission)->first();
    }

    public static function fileHasDeletePermission($file, $permissionType = "delete")
    {
        if (!$file)
            return false;

        $permission = Permission::getPermission($permissionType);
        $hasPermission = false;

        $sharedFolders = DocumentPermission::where("document_id", $file->id)
            ->where("user_id", Auth::user()->id)
            ->where("permission_id",$permission->id)
            ->first();

        if ($sharedFolders) {
            $hasPermission =  true;
        }

        if (Auth::user()->role == "admin") {
            return true;
        }

        if (self::canManage(Auth::user()->id, $file->created_by)) {
            return true;
        }

        if ($hasPermission) {
            return true;
        }

        return false;
    }

    public static function canManage($user_managing_id, $user_to_be_managed_id)
    {
        $manage_user = \App\Models\UserManage::where("user_id", $user_managing_id)
            ->where("manage_user_id", $user_to_be_managed_id)
            ->exists();

        return $manage_user;
    }
}
