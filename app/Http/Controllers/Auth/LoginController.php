<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function postlogin(Request $request)
    {
        // jika au
        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->level == "admin") {
                return redirect('/home');
            } elseif (auth()->user()->level == "customerservice") {
                return redirect('/dashboard_cs');
            } elseif (auth()->user()->level == "owner") {
                return redirect('/dashboard_owner');
            }
        }
        return redirect('login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
