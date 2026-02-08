<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        public string $id,
        public string $avatar,
        public string $username,
        public string $email,
        public ?string $email_verified_at,
        public string $created_at,
        public string $updated_at,
    ) {}
}
