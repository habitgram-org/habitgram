<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;

final class ProfileController
{
    public function show(string $username): Response
    {
        $user = User::where('username', $username)->firstOrFail();

        return inertia('profile/show', ['user' => $user]);
    }
}
