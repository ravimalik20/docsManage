<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class History extends Model
{
    protected $table = "history";
    protected $guarded = array();

    public static function store($request){
        $file = File::find($request["document_id"]);

        $history              = new History;
        $history->user_id     = $request["user_id"];
        $history->document_id = $request["document_id"];
        $history->type        = $request["type"];
        $history->status      = $request["status"];
        $history->reason      = $request["reason"];
        $history->uploaded_by = isset($request["uploaded_by"]) ? $request["uploaded_by"] : null;
        $history->filename = $file->name;
        $history->save();
        return 1;
    }

    public function hasOneFile(){
      return $this->hasOne("App\Models\File","id","document_id");
    }

    public function hasOneUser(){
      return User::find($this->uploaded_by);
    }

}
