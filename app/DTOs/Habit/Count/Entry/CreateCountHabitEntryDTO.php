<?php

declare(strict_types=1);

namespace App\DTOs\Habit\Count\Entry;

use Spatie\LaravelData\Dto;

final class CreateCountHabitEntryDTO extends Dto
{
    public function __construct(
        public int $amount,
        public ?string $note,
    ) {}
}
