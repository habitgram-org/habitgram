<?php

declare(strict_types=1);

namespace App\Data\CountHabit;

use App\Models\Count\CountHabitEntry;
use Spatie\LaravelData\Data;

final class CountHabitEntryData extends Data
{
    public function __construct(
        public string $id,
        public int $amount,
        public ?string $created_at,
    ) {}

    public static function fromModel(CountHabitEntry $countHabitEntry): self
    {
        return new self(
            id: $countHabitEntry->id,
            amount: $countHabitEntry->amount,
            created_at: $countHabitEntry->created_at?->shortRelativeDiffForHumans(),
        );
    }
}
