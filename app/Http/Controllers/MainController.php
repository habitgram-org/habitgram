<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Response;

final class MainController
{
    public function index(): Response
    {
        if (auth()->check()) {
            if (! auth()->user()?->hasVerifiedEmail()) {
                return inertia('auth/verify-email');
            }

            return inertia('habits/show', [
                'habit' => [],
            ]);
        }

        return inertia('auth/login');
    }
}
