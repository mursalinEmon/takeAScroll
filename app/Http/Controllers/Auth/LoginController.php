<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

// use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */




    public function redirectTo() {

        $user = Auth::user();
        $user1=$user->name.$user->id.'-'.time();
        Session::put('unique'.$user->id,$user1);
        // dd(Session::get('unique'.$user->id));

        switch(true) {
            case $user->type=='vendor':
                return '/vendor-dashboard';
            case $user->type=='customer':
                return '/';
            case $user->type=='admin':
                return '/admin-dashboard';
            default:
                return '/';
        }

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
