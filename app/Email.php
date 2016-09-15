<?php
namespace App;
use Auth;
use App\Models\Folder,App\Models\File, App\Models\DocumentPermission, App\Models\History;
use Mail;
class Email
{

    public static function fileUpload($user)
    {
        Mail::send('email.file_upload', ["user"=>$user], function($message) use ($user) {
            $message->to($user->email, $user->name)->subject($user->subject);
        });
    }

    public static function fileDelete()
    {
        Mail::send('email.file_upload', ["user"=>$user], function($message) use ($user) {
            $message->to($user->email, $user->name)->subject($user->subject);
        });
    }
}
