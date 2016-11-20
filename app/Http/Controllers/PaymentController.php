<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User, Auth, Session, App\PaymentCard, Validator, App\PaymentLog, App\PaymentRequest;
class PaymentController extends Controller
{

    protected function validator(array $data, $rules)
    {
        return Validator::make($data, $rules);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['page'] = 'payment';
        $data['payment_requests'] = PaymentRequest::getPaymentRequests(Auth::user());
        $data['paymentlogs'] = PaymentLog::getPaymentLogs(Auth::user());
        return view('index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->amount) {
            return response()->json(['status'=>'error', 'message'=> 'Amount field is required.'], 402);
        }
        $requestAmount = PaymentRequest::find($request->payment_request_id);
        if($request->amount > $requestAmount->current_amount) {
          return response()->json(['status'=>'error', 'message'=> 'Amount cannot be greater than due amount.'], 402);
        }

        $user = User::find(Auth::user()->id);
        $charge = PaymentCard::charge($user, $request);
        if(!$charge) {
          return response()->json(['status'=>'error', 'message'=>'Payment error'], 402);
        }
        $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["Payment successfully"]];
        Session::flash("message",$msg);
        return response()->json(['status'=>'success', 'message'=>'Payment successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function paymentcards(){
      $data = [];
      $cards = PaymentCard::paymentcards(Auth::user());
      if(count($cards) > 0){
        foreach($cards as $card){
            $card->card = json_decode($card->card);
            array_push($data, $card);
        }
      }
      return response()->json($data, 200);
    }
}
