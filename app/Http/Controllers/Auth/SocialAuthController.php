<?php

namespace lexpoint\Http\Controllers\Auth;

use Illuminate\Http\Request;

use lexpoint\Http\Requests;
use lexpoint\Http\Controllers\Controller;
use Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to provider Google, Github
     */
    public function redirect($provider)
    {
        return \Socialite::driver( $provider )->redirect();
    }


    public function callback($provider)
    {
        $user = \Socialite::driver($provider)->user();
//        dd($user);
// getId(), getNickname(), getName(), getEmail(), getAvatar()
/*
    // storing data to our use table and logging them in
    $data = [
        'name' => $user->getName(),
        'email' => $user->getEmail()
    ];
    
     // Here, check if the user already exists in your records

    $my_user = User::where('email','=', $user->getEmail())->first();
    if($my_user === null) {
            Auth::login(User::firstOrCreate($data));
    } else {
        Auth::login($my_user);
    }

    //after login redirecting to home page
    return redirect($this->redirectPath());
*/
        return view('index');
    }
}
