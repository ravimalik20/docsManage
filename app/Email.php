<?php
namespace App;
use Auth;
use App\Models\Folder,App\Models\File, App\Models\DocumentPermission, App\Models\History;
use Mail;
class Email
{

  public static function fileUpload($user)
  {

    $data = ["email"=>$user->email,"name"=>$user->name,"subject"=>$user->subject,"body"=>$user->body];
    Mail::send('email.file_upload', $data, function($message) use ($data)
      {
        $message->to($data["email"], $data["name"])->subject($data["subject"]);
      });
  }

  public static function fileDelete()
  {

  }


}
