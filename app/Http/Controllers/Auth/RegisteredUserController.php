<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\CreateNewUser;
use App\Http\Requests\Auth\StoreUserRequest;
use Illuminate\Auth\Events\Registered;
use Inertia\Response;
use Throwable;

final class RegisteredUserController
{
    public function create(): Response
    {
        return inertia('auth/signup');
    }

    /**
     * @throws Throwable
     */
    public function store(StoreUserRequest $request, CreateNewUser $createNewUser)
    {
        $user = $createNewUser->run($request->getDTO());

        auth()->login($user);

        event(new Registered($user));

        return redirect()->route('index');
    }
}
