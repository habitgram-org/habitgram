<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Spatie\LaravelData\Resource;

final class UserResource extends Resource
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

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            avatar: $user->avatar,
            username: $user->username,
            email: $user->email,
            email_verified_at: $user->email_verified_at?->toDayDateTimeString(),
            created_at: $user->created_at->toDayDateTimeString(),
            updated_at: $user->updated_at->toDayDateTimeString(),
        );
    }
}
