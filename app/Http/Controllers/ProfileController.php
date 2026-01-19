<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;

class ProfileController
{
    public function show(string $username): Response
    {
        $user = User::where('username', $username)->firstOrFail();

        return inertia('profile/show', ['user' => $user]);
    }
}
