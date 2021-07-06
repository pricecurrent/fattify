<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'layouts.app';

    /**
     * Determines the current asset version.
     *
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => fn () => $this->transformUser(),
                'check' => fn () => auth()->check(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }

    protected function transformUser()
    {
        $user = auth()->user();

        return $user
            ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'bio' => $user->bio,
                'avatar_url' => $user->getAvatarUrl(),
            ]
            : null;
    }
}
