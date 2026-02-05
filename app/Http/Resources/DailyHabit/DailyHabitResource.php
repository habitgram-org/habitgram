<?php

declare(strict_types=1);

namespace App\Http\Resources\DailyHabit;

use App\Models\Daily\DailyHabit;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class DailyHabitResource extends Resource
{
    /**
     * @param  DataCollection<int, DailyHabitEntryResource>  $entries
     */
    public function __construct(
        public string $id,
        public DataCollection $entries,
        public Optional|string $created_at,
        public int $longest_streak_days,
        public int $current_streak_days,
        public int $total_completions,
        public int $completion_rate,
        public string $today_date,
        public string $max_streak_start,
        public string $max_streak_end,
        public bool $is_today_completed,
        public int $year,
        public int $completed_days_in_year,
    ) {}

    public static function fromModel(DailyHabit $dailyHabit): self
    {
        return new self(
            id: $dailyHabit->id,
            entries: DailyHabitEntryResource::collect(
                items: $dailyHabit->entries,
                into: DataCollection::class,
            ),
            created_at: $dailyHabit->created_at?->toDayDateTimeString(),
            longest_streak_days: 999,
            current_streak_days: 0,
            total_completions: 0,
            completion_rate: 0,
            today_date: now()->toFormattedDateString(),
            max_streak_start: CarbonImmutable::createFromDate(2022, 6, 12)->toDateString(),
            max_streak_end: CarbonImmutable::createFromDate(2022, 11, 17)->toDateString(),
            is_today_completed: $dailyHabit->is_today_completed,
            year: now()->year,
            completed_days_in_year: 999,
        );
    }
}
