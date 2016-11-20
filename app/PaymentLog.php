<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $table = 'payment_logs';
    protected $guarded = array();

    public static function store($user, $request){
      $log = new PaymentLog;
      $log->user_id = $user->id;
      $log->amount = ($request->charge['amount'] / 100);
      $log->status = $request->charge['status'];
      $log->stripe_token = $request->charge['id'];
      $log->save();
      return true;
    }

    public static function getPaymentLogs($user){
      return PaymentLog::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
    }
}
