<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Inertia\Inertia;

class RegisterController
{
    public function show()
    {
        return Inertia::render('Auth/Register', [
            'invite_code' => request('invite_code'),
        ]);
    }

    public function store(RegisterRequest $request)
    {
        $user = tap(User::create(array_merge($request->validated(), ['password' => bcrypt($request->password)])), fn ($user) => auth()->login($user));

        return redirect()->route('diary')->with('success', "Hello, {$user->name}");
    }
}
