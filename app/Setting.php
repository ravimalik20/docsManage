<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;
use Auth;
class Setting extends Model
{
    protected $table = "settings";
    protected $guarded = array();


    public static function store($request){
      $settings = $request->emailsettings;
      Setting::where("user_id",Auth::user()->id)->delete();
      if(count($settings)>0){
        foreach($settings as $setting){
            $set = Setting::firstOrNew(array("user_id"=>Auth::user()->id,"name"=>$setting));
            $set->name = $setting;
            $set->user_id = Auth::user()->id;
            $set->status = true;
            $set->save();
        }
      }
    }

    public static function settings(){
      $usersettings = [];
      $settings = Setting::select("name")->where("user_id",Auth::user()->id)->get();
      if(count($settings) > 0){
        foreach($settings as $setting){
          array_push($usersettings, $setting->name);
        }
      }
      return $usersettings;
    }

    public static function emailSetting($setting){
      $setting = Setting::where("user_id",Auth::user()->id)->where("name", $setting)->first();
      if($setting){
        return true;
      }
      return false;
    }
}
