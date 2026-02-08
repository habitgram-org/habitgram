<?php

declare(strict_types=1);

namespace App\Data\AbstinenceHabit;

use App\Models\Abstinence\AbstinenceHabit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Spatie\LaravelData\Data;

final class AbstinenceHabitData extends Data
{
    /**
     * @param  Collection<int, AbstinenceHabitRelapseData>  $relapses
     */
    public function __construct(
        public string $id,
        public Collection $relapses,
        public int $relapses_count,
        public ?string $created_at,
        public int $max_streak_days,
        public string $max_streak_start,
        public string $max_streak_end,
        public int $duration,
        public ?string $goal,
        public ?string $goal_current,
        public ?int $goal_progress,
        public ?string $goal_remaining,
        public ?string $goal_unit,
    ) {}

    public static function fromModel(AbstinenceHabit $abstinenceHabit): self
    {
        return new self(
            id: $abstinenceHabit->id,
            relapses: AbstinenceHabitRelapseData::collect($abstinenceHabit->relapses),
            relapses_count: $abstinenceHabit->relapses_count,
            created_at: $abstinenceHabit->created_at?->toDayDateTimeString(),
            max_streak_days: 159,
            max_streak_start: CarbonImmutable::createFromDate(2022, 6, 12)->toDateString(),
            max_streak_end: CarbonImmutable::createFromDate(2022, 11, 17)->toDateString(),
            duration: $abstinenceHabit->duration,
            goal: isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->goal, locale: 'sv') : null,
            goal_current: isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->goal_current, locale: 'sv') : null,
            goal_progress: $abstinenceHabit->progress,
            goal_remaining: isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->remaining, locale: 'sv') : null,
            goal_unit: isset($abstinenceHabit->goal) ? lcfirst($abstinenceHabit->goal_unit->name) : null,
        );
    }
}
