<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth, DB;
class Message extends Model
{
  protected $table = "messages";
  protected $guarded = array();

  public static function getMessages($user, $id){
      self::messageStatusChange($user, $id);
      $messages = Message::select('users.*','messages.message', 'messages.id as message_id', 'messages.status')
                ->join('users','users.id','=','messages.sender_id')
                ->where('messages.sender_id',$user->id)
                ->where('messages.receiver_id', $id)
                ->where('file_request_id', 0)
                ->orWhere(function($q) use($id, $user) {
                  $q->where('messages.receiver_id', $user->id)
                    ->where('messages.sender_id', $id)
                    ->where('file_request_id', 0);
                })
                ->get();
      return $messages;
    }
    public static function messageStatusChange($user, $id) {
      Message::where('sender_id', $user->id)
                ->where('receiver_id',$id)
                ->where('status', 'received')
                ->update(['status' => 'read']);
    return true;
    }

    public static function userMessages($user) {
      $user_messages = Message::select('users.*','messages.message', 'messages.id as message_id', DB::raw('count(*) as total'), 'messages.receiver_id', 'messages.sender_id', 'messages.status')
                ->join('users','users.id','=','messages.receiver_id')
                ->where('messages.sender_id', $user->id)
                ->orWhere(function($q) use($user) {
                  $q->where('messages.receiver_id', $user->id)
                    ->where('file_request_id', 0);
                })
                ->where('file_request_id', 0)
                ->orderBy('messages.id', 'DESC')
                ->groupBy('messages.receiver_id')
                ->get();
      return self::filterMessage($user_messages);
    }

    private static function filterMessage($user_messages) {
        $finalRow = [];
        foreach($user_messages as $user_message) {
          if(array_key_exists(($user_message->sender_id.'_'.$user_message->receiver_id), $finalRow) || array_key_exists(($user_message->receiver_id.'_'.$user_message->sender_id), $finalRow)){
            continue;
          }
          else
          {
            $finalRow[$user_message->sender_id.'_'.$user_message->receiver_id] = $user_message;
          }
        }
      return $finalRow;
    }
}
