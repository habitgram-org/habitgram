<?php

declare(strict_types=1);

namespace App\Http\Resources\CountHabit;

use App\Models\Count\CountHabitEntry;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class CountHabitEntryResource extends Resource
{
    public function __construct(
        public string $id,
        public int $amount,
        public Optional|string $created_at,
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
