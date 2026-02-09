<?php

declare(strict_types=1);

namespace App\Data\AbstinenceHabit;

use App\Models\Abstinence\AbstinenceHabit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

final class AbstinenceHabitData extends Data
{
    /**
     * @param  Collection<int, AbstinenceHabitRelapseData>|Lazy  $relapses
     */
    public function __construct(
        public string $id,
        public Collection|Lazy $relapses,
        public int|Lazy $relapses_count,
        public null|string|Lazy $created_at,
        public int|Lazy $max_streak_days,
        public string|Lazy $max_streak_start,
        public string|Lazy $max_streak_end,
        public int|Lazy $duration,
        public null|string|Lazy $goal,
        public null|string|Lazy $goal_current,
        public null|int|Lazy $goal_progress,
        public null|string|Lazy $goal_remaining,
        public null|string|Lazy $goal_unit,
    ) {}

    public static function fromModel(AbstinenceHabit $abstinenceHabit): self
    {
        return new self(
            id: $abstinenceHabit->id,
            relapses: Lazy::create(fn () => AbstinenceHabitRelapseData::collect($abstinenceHabit->relapses)),
            relapses_count: Lazy::create(fn () => $abstinenceHabit->relapses_count),
            created_at: Lazy::create(fn () => $abstinenceHabit->created_at?->toDayDateTimeString()),
            max_streak_days: Lazy::create(fn () => 159),
            max_streak_start: Lazy::create(fn () => CarbonImmutable::createFromDate(2022, 6, 12)->toDateString()),
            max_streak_end: Lazy::create(fn () => CarbonImmutable::createFromDate(2022, 11, 17)->toDateString()),
            duration: Lazy::create(fn () => $abstinenceHabit->duration),
            goal: Lazy::create(fn () => isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->goal, locale: 'sv') : null),
            goal_current: Lazy::create(fn () => isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->goal_current, locale: 'sv') : null),
            goal_progress: Lazy::create(fn () => $abstinenceHabit->progress),
            goal_remaining: Lazy::create(fn () => isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->remaining, locale: 'sv') : null),
            goal_unit: Lazy::create(fn () => isset($abstinenceHabit->goal) ? lcfirst($abstinenceHabit->goal_unit->name) : null),
        );
    }
}
