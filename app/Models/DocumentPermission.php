<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentPermission extends Model
{
    protected $table = "document_permission";
    protected $guarded = array();

    public static function store($request){
      $documentId = $request->documentId;
      $document_type = $request->document_type;
      if(count($request->users)){
        foreach($request->users as $key=>$user){
          $userId = $key;
          DocumentPermission::where("user_id",$userId)->where("document_id",$documentId)->delete();
          if(is_array($user)){
            foreach($user["permission"] as $permissionId){
              $permissions = $user["permission"];
              $permission = DocumentPermission::firstOrNew(array("user_id"=>$userId,"document_id"=>$documentId,"permission_id"=>$permissionId));
              $permission->user_id = $userId;
              $permission->document_id = $documentId;
              $permission->type = $document_type;
              $permission->permission_id = $permissionId;
              $permission->save();
            }
          }
        }
      }
      return 1;
    }
}
