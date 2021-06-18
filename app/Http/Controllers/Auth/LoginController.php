<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class LoginController
{
    public function showLoginForm()
    {
        return inertia('Auth/Login');
    }

    public function login(Request $request)
    {
        auth()->attempt($request->only('email', 'password'), $request->remember);
        return redirect()->route('diary');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
