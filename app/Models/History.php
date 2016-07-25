<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = "history";
    protected $guarded = array();

    public static function store($request){
        $history              = new History;
        $history->user_id     = $request["user_id"];
        $history->document_id = $request["document_id"];
        $history->type        = $request["type"];
        $history->status      = $request["status"];
        $history->reason      = $request["reason"];
        $history->save();
        return 1;
    }
}
