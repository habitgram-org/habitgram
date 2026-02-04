<?php

declare(strict_types=1);

namespace App\DTOs\Habit\Note;

use Spatie\LaravelData\Dto;

final class CreateHabitNoteDTO extends Dto
{
    public function __construct(
        public string $note,
    ) {}
}
