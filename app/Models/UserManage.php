<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;

class UserManage extends Model
{
  protected $table = "user_manage";
  protected $guarded = array();

    public static function store($ids)
    {
        $manageId = Session::get('selected_user');
        UserManage::where('manage_user_id', $manageId)->delete();

        foreach ($ids as $id) {
          $permissions = new UserManage;
          $permissions->user_id         = $id;
          $permissions->permission_id   = 5;
          $permissions->manage_user_id  = $manageId;
          $permissions->save();
        }
    }

    public static function permissions()
    {
        $manageId = Session::get('selected_user');
        $ids = [];
        $users = UserManage::where('manage_user_id',$manageId)
            ->select('user_id')->get();

        foreach ($users as $user) {
            array_push($ids, $user->user_id);
        }

        return $ids;
    }
}
