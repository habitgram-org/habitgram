<?php

declare(strict_types=1);

namespace App\Http\Resources\DailyHabit;

use App\Models\Daily\DailyHabitEntry;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class DailyHabitEntryResource extends Resource
{
    public function __construct(
        public string $id,
        public Optional|string $succeeded_at,
        public Optional|string $failed_at,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(DailyHabitEntry $entry): self
    {
        return new self(
            id: $entry->id,
            succeeded_at: $entry->succeeded_at?->toDayDateTimeString() ?? Optional::create(),
            failed_at: $entry->failed_at?->toDayDateTimeString() ?? Optional::create(),
            created_at: $entry->created_at?->toDayDateTimeString() ?? Optional::create(),
        );
    }
}
