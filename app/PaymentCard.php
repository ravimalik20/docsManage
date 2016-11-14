<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth, Stripe;
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
          'currency' => 'USD',
          'amount'   => ($request->amount)? $request->amount : 1,
      ]);

      if($charge){

        //make this card default
        if(!$user->stripe_id) {
          $request->card = $charge['source'];
          self::store($request);
          $user->stripe_id = $customer['id'];
          $user->save();
        }
      }
      return $charge;
    }

    public static function store($request) {
      $card = new PaymentCard;
      $card->user_id = Auth::user()->id;
      $card->token = $request->token;
      $card->card = json_encode($request->card);
      $card->save();
      return true;
    }

    public static function paymentcards($user) {
      return PaymentCard::where('user_id', $user->id)->get();
    }
}
