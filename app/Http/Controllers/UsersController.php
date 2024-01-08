<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UsersController
{
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->avatar) {
            $avatarPath = $request->avatar->store('/', 'avatars');
        }
        $user->update(array_merge($request->validated(), ['avatar' => $avatarPath ?? $user->avatar]));

        return redirect()->back()->with('success', 'Updated!');
    }
}
