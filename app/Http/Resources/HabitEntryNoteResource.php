<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class HabitEntryNoteResource extends Resource
{
    public function __construct(
        public string $id,
        public string $content,
        public Optional|string $created_at,
    ) {}
}
