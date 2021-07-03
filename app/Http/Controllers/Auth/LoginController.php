<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function showLoginForm()
    {
        return inertia('Auth/Login');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => ['required', 'email'], 'password' => 'required']);

        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            throw ValidationException::withMessages(['email' => 'Invalid credentials']);
        }

        return redirect()->route('diary')->with('success', 'Welcome, '.auth()->user()->name);
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
