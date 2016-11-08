<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message, Auth;
class FileRequest extends Model
{
    protected $table = "file_request";
    protected $guarded = array();

    public static function store($request)
    {
        $table = new FileRequest;
        $table->user_id = \Session::get("selected_user");
        $table->is_uploaded = false;
        $table->description = $request->description;
        $table->folder_id = $request->folderselect;
        $table->type = $request->type;
        $table->save();
        if($request->has('message') && $request->message != '') {
          $message = Message::firstOrNew(array('file_request_id'=>$table->id));
          $message->message = $request->message;
          $message->receiver_id = \Session::get("selected_user");
          $message->sender_id = Auth::user()->id;
          $message->save();
        }
        return true;
    }

    public static function userfilerequest($id)
    {
        $files = FileRequest::where('user_id', $id)->get();

        return $files;
    }

    public static function fileIsUploaded ($id)
    {
        FileRequest::where('id', $id)->update(['is_uploaded'=>true]);

        return true;
    }

    public function has_messages(){
      return $this->hasMany('App\Message','file_request_id','id');
    }

    public static function saveMessage($request){
      $table = Message::firstOrNew(array('file_request_id'=>$request->file_request_id, 'receiver_id'=>$request->file_message_receiver));
      $table->receiver_id = $request->file_message_receiver;
      $table->sender_id = Auth::user()->id;
      $table->message = $request->message;
      $table->file_request_id = $request->file_request_id;
      $table->save();

      return true;
    }

    public function sender()
    {
      return $this->hasOne('App\Message','file_request_id','id');
    }
}
