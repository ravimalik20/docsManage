<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class PaymentRequest extends Model
{
    protected $table = 'payment_requests';
    protected $guarded  = array();


    public static function paymentRequests(){
      return PaymentRequest::select('payment_requests.*', 'users.name', 'users.account_balance', 'users.email')
                ->join('users', 'users.id' ,'=', 'payment_requests.user_id')
                ->where('requested_by', Auth::user()->id)
                ->orderBy('created_at', 'DESC')
                ->get();
    }

    public static function getPaymentRequests($user){
      return PaymentRequest::select('payment_requests.*', 'users.name', 'users.account_balance')
                ->join('users', 'users.id' ,'=', 'payment_requests.requested_by')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'DESC')
                ->get();
    }

}
