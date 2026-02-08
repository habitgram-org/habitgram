<?php

declare(strict_types=1);

namespace App\Data\AbstinenceHabit;

use App\Models\Abstinence\AbstinenceHabitRelapse;
use Spatie\LaravelData\Data;

final class AbstinenceHabitRelapseData extends Data
{
    public function __construct(
        public string $id,
        public string $happened_at,
        public string $reason,
        public int $streak_days,
        public ?string $created_at,
    ) {}

    public static function fromModel(AbstinenceHabitRelapse $abstinenceHabitEntry): self
    {
        // take previous, take current relapse, calculate the diff in days between them
        // this will be streak days (?)

        return new self(
            id: $abstinenceHabitEntry->id,
            happened_at: $abstinenceHabitEntry->happened_at->toDayDateTimeString(),
            reason: $abstinenceHabitEntry->reason,
            streak_days: 123,
            created_at: $abstinenceHabitEntry->created_at?->toDayDateTimeString(),
        );
    }
}
