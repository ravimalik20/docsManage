<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User, App\PaymentRequest, Session, Auth;
class PaymentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['page'] = 'paymentrequest';
        $data['payment_requests'] = PaymentRequest::paymentRequests();
        return view('master', $data);
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
        if(!$request->amount){
          $msg = ["type"=>"alert-error","icon"=>"fa-ban","data"=>["Amount field is required."]];
          Session::flash("message",$msg);
          return back();
        }
        $user = User::find(Session::get('selected_user'));
        $payment_request  = new PaymentRequest;
        $payment_request->user_id = $user->id;
        $payment_request->requested_by = Auth::user()->id;
        $payment_request->amount = (float) $request->amount;
        $payment_request->current_amount = (float) $request->amount;
        $payment_request->save();

        $user->amount_due = (float) $user->amount_due + (float) $request->amount;
        $user->save();

        $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["Amount adedd successfully."]];
        Session::flash("message",$msg);
        return back();
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
}
