<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DTOs\Auth\CreateNewUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateNewUser
{
    /**
     * @throws Throwable
     */
    public function run(CreateNewUserDTO $dto): User
    {
        return DB::transaction(fn () => User::create([
            'username' => mb_ltrim($dto->username, '@'),
            'email' => $dto->email,
            'password' => bcrypt($dto->password),
        ]));
    }
}
