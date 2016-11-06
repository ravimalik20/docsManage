<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FileRequest, Validator, Session, Auth;
class fileRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data, $rules)
    {
        return Validator::make($data, $rules);
    }
    public function index()
    {
        $data = [];
        $data['page']  = 'userfilerequest';
        $data['filerequests'] =  FileRequest::userfilerequest(Auth::user()->id);
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
        $v =  $this->validator($request->all(), ['description'=>'required', 'type'=>'required']);
        if($v->fails()){
          return back()->withErrors($v);
        }
        FileRequest::store($request);
        $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["File request submitted successfully"]];
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
    public function destroy(Request $request)
    {
        $file_request = FileRequest::find($request->id);
        if($file_request) {
            $file_request->delete();
            return ['status'=>'success'];
        }
        return ['status'=>'error'];
    }
}
