<?php

declare(strict_types=1);

namespace App\Http\Resources\AbstinenceHabit;

use App\Models\Abstinence\AbstinenceHabit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Number;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class AbstinenceHabitResource extends Resource
{
    /**
     * @param  DataCollection<int, AbstinenceHabitEntryResource>  $relapses
     */
    public function __construct(
        public string $id,
        public DataCollection $relapses,
        public int $relapses_count,
        public Optional|string $created_at,
        public int $max_streak_days,
        public string $max_streak_start,
        public string $max_streak_end,
        public int $duration,
        public Optional|string $goal,
        public Optional|string $goal_current,
        public Optional|int $goal_progress,
        public Optional|string $goal_remaining,
        public Optional|string $goal_unit,
    ) {}

    public static function fromModel(AbstinenceHabit $abstinenceHabit): self
    {
        $relapses = AbstinenceHabitEntryResource::collect(
            items: $abstinenceHabit->relapses,
            into: DataCollection::class,
        );

        return new self(
            id: $abstinenceHabit->id,
            relapses: $relapses,
            relapses_count: $abstinenceHabit->relapses_count,
            created_at: $abstinenceHabit->created_at?->toDayDateTimeString(),
            max_streak_days: 159,
            max_streak_start: CarbonImmutable::createFromDate(2022, 6, 12)->toDateString(),
            max_streak_end: CarbonImmutable::createFromDate(2022, 11, 17)->toDateString(),
            duration: $abstinenceHabit->duration,
            goal: isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->goal, locale: 'sv') : Optional::create(),
            goal_current: isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->goal_current, locale: 'sv') : Optional::create(),
            goal_progress: $abstinenceHabit->progress ?? Optional::create(),
            goal_remaining: isset($abstinenceHabit->goal) ? Number::format($abstinenceHabit->remaining, locale: 'sv') : Optional::create(),
            goal_unit: isset($abstinenceHabit->goal) ? lcfirst($abstinenceHabit->goal_unit->name) : Optional::create(),
        );
    }
}
