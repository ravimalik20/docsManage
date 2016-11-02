<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
echo "hello";
class Home extends Model
{
    protected $table = "home";
    protected $guarded = array();

    public static function store($request){
        $$user = USER::find($request["user_id"]);

        $home             = new Home;
        $home->user_id     = $request["user_id"];
        $home->name = $request["name"];
        

}
