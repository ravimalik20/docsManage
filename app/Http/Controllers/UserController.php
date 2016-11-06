<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Folder, App\Models\File, App\User, Auth;

use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['page']  = 'user_home';
        $data['users'] = User::lists();

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [];
        $user = User::find($id);
        $data['user'] = $user;
        $data['page']  = 'userdocuments';
        $data['documents'] = User::documents($user,0);

        return view('master', $data);
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

    public function userFolderDocument($userID, $folderID)
    {
        $data = [];
        $user = User::find($userID);

        $data['user'] = $user;
        $data['page']  = 'userdocuments';
        $data['documents'] = User::documents($user,$folderID);

        return view('master', $data);
    }

    public function userHistory($userID){
        $data = [];
        $data["page"] = "user_history";
        $user = User::find($userID);
        $data["histories"] = $user->history();
        return view("master", $data);
    }

	public function userHome($userID){
        $user = User::find($userID);
		$data = [];
	        $data["page"] = "user_home";
        $data["userName"] = $user->name;


        return view("master", $data);
    }
    public function selectUser($user_id)
    {
        if ($user_id == 0) {
            Session::forget("selected_user");

            return ["status" => "success"];
        }

        $user = \App\user::find($user_id);

        if ($user) {
            Session::put("selected_user", $user_id);
        }

        return ["status" => "success"];
    }
}
