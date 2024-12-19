<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginuser(LoginRequest $request)
    {
        $user_info = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($user_info)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'email'=>'メールアドレスが間違っています。',
            'password' => 'パスワードが間違っています。'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
