<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function index()
    {
        if (auth()->user() == null) {
            return view('login.login');
        } else {
            return redirect('dashboard');
        }
    }
    public function postlogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if (!$user) {
            $validator = Validator::make($request->all(), [
                'email' => ['required'],
                'password' => ['required'],
            ], [
                'email.required' => 'Email harap di isi',
                'password.required' => 'Password harap di isi',
            ]);
            if ($validator->fails()) {
                return redirect('login')
                    ->withErrors($validator)
                    ->withInput();
            }
            return redirect('login')->with('error', 'Login Gagal, harap periksa kembali email anda');
        }
        if (!Hash::check($password, $user->password)) {
            $validator = Validator::make($request->all(), [
                'email' => ['required'],
                'password' => ['required'],
            ], [
                'email.required' => 'Email harap di isi',
                'password.required' => 'Password harap di isi',
            ]);
            if ($validator->fails()) {
                return redirect('login')
                    ->withErrors($validator)
                    ->withInput();
            }
            return redirect('login')->with('error', 'Login Gagal, harap periksa kembali password anda');
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            activity()->log('Telah log in');
            return redirect('/dashboard');
        }
        return redirect('login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}
