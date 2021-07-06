<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ProfileController
{
    public function __invoke()
    {
        return Inertia::render('Profile');
    }
}
