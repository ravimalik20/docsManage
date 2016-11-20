<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth, Stripe, App\PaymentLog, App\PaymentRequest;
class PaymentCard extends Model
{
    protected $table = 'payment_cards';
    protected $guarded = array();


    public static function charge($user, $request) {

      if(!$user->stripe_id){
        $customer = Stripe::customers()->create([
            'email' => $user->email,
            'source'=> $request->token
        ]);
      }

      $charge = Stripe::charges()->create([
          'customer' => ($user->stripe_id)? $user->stripe_id : $customer['id'],
          'currency' => 'cad',
          'amount'   => $request->amount,
      ]);

      //save payment logs
      $request->charge = $charge;
      PaymentLog::store($user, $request);

      if($charge){
        // Update user account balance
        self::updateAccountBalance($user, $request->amount);

        // update payment requests
        self::updatePaymentRequest($user, $request);

        //Save stripe customer id
        if(!$user->stripe_id) {
          $user->stripe_id = $customer['id'];
          $user->save();
        }

        //Save card
        if($request->has('save_card') && $request->save_card == 'save_card') {
          $request->card = $charge['source'];
          self::store($request);
        }
      }
      return $charge;
    }

    public static function updateAccountBalance($user, $amount){
       $accountbal = (float) $user->account_balance + (float) $amount;
       $amount_due = (float) $user->amount_due - (float) $amount;
        $user->account_balance = $accountbal;
        $user->amount_due = $amount_due;
        $user->save();
        return true;
    }

    public static function store($request) {
      $card = new PaymentCard;
      $card->user_id = Auth::user()->id;
      $card->token = $request->token;
      $card->card = json_encode($request->card);
      $card->save();
      return true;
    }

    public static function updatePaymentRequest($user, $request){
        $payment_request = PaymentRequest::find($request->payment_request_id);
        if(!$payment_request){
          return false;
        }

        if((float) $payment_request->amount == (float) $request->amount){
            $payment_request->is_complete = true;
        }
        $payment_request->current_amount = (float) $payment_request->current_amount - (float) $request->amount;
        $payment_request->save();
        return true;
    }

    public static function paymentcards($user) {
      return PaymentCard::where('user_id', $user->id)->get();
    }
}
