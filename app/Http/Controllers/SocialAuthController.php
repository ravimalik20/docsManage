<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Folder;
use App\Models\File;
use App\User;

use Socialite;
use Auth;

class SocialAuthController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleRedirectHandler()
    {
        $user_g = Socialite::driver('google')->user();
        if (!$user_g)
            return abort(404);

        $user = User::firstOrCreate([
            "name" => $user_g->name,
            "email" => $user_g->email,
        ]);

        Auth::loginUsingId($user->id);

        return redirect('/');
    }
}
