<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class HabitNoteData extends Data
{
    public function __construct(
        public string $id,
        public string $note,
        public ?string $created_at,
    ) {}
}
