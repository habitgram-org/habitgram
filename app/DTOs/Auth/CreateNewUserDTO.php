<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

use Spatie\LaravelData\Dto;

final class CreateNewUserDTO extends Dto
{
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
    ) {}
}
