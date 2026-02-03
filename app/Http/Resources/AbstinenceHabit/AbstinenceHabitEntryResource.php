<?php

declare(strict_types=1);

namespace App\Http\Resources\AbstinenceHabit;

use App\Models\Abstinence\AbstinenceHabitEntry;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class AbstinenceHabitEntryResource extends Resource
{
    public function __construct(
        public string $id,
        public string $happened_at,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(AbstinenceHabitEntry $abstinenceHabitEntry): self
    {
        return new self(
            id: $abstinenceHabitEntry->id,
            happened_at: $abstinenceHabitEntry->happened_at->toDayDateTimeString(),
            created_at: $abstinenceHabitEntry->created_at?->toDayDateTimeString(),
        );
    }
}
