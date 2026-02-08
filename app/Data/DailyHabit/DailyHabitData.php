<?php

declare(strict_types=1);

namespace App\Data\DailyHabit;

use App\Models\Daily\DailyHabit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final class DailyHabitData extends Data
{
    private const int DAYS_IN_LEAP_YEAR = 366;

    private const int DAYS_IN_USUAL_YEAR = 365;

    /**
     * @param  Collection<int, DailyHabitEntryData>  $entries
     */
    public function __construct(
        public string $id,
        public Collection $entries,
        public ?string $created_at,
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
            entries: self::getDailyEntries($dailyHabit),
            created_at: $dailyHabit->created_at?->toDayDateTimeString(),
            longest_streak_days: 999,
            current_streak_days: 0,
            total_completions: 0,
            completion_rate: 0,
            today_date: now()->toFormattedDateString(),
            max_streak_start: CarbonImmutable::createFromDate(2022, 6, 12)->toDateString(),
            max_streak_end: CarbonImmutable::createFromDate(2022, 11, 17)->toDateString(),
            is_today_completed: $dailyHabit->is_today_completed,
            year: 2025,
            completed_days_in_year: 999,
        );
    }

    /**
     * @return Collection<int, DailyHabitEntryData>
     */
    private static function getDailyEntries(DailyHabit $dailyHabit): Collection
    {
        /** @var Collection<int, DailyHabitEntryData> $entries */
        $entries = collect();
        foreach ($dailyHabit->entries as $entry) {
            // Calculating and pushing either completed or missed days
            $entries->push(DailyHabitEntryData::from([
                'id' => $entry->id,
                'is_succeeded' => (bool) ($entry->succeeded_at ?? $entry->failed_at),
                'is_future' => false,
                'date' => $entry->created_at?->toDayDateTimeString(),
                'created_at' => $entry->created_at,
            ]));
        }

        // Calculating the "none" and future days
        collect(range(1, now()->isLeapYear() ? self::DAYS_IN_LEAP_YEAR : self::DAYS_IN_USUAL_YEAR))
            ->diff($entries->map(fn (DailyHabitEntryData $e) => $e->created_at->dayOfYear)->all())
            ->each(function (int $value) use ($entries): void {
                $date = now()->setYear(2025)->startOfYear()->setDay($value);
                $entries->push(DailyHabitEntryData::from([
                    'date' => $date->toDayDateTimeString(),
                    'is_future' => $date->isFuture(),
                    'created_at' => $date,
                ]));
            });

        return $entries->sort(function (DailyHabitEntryData $a, DailyHabitEntryData $b) {
            return $a->created_at->dayOfYear < $b->created_at->dayOfYear ? -1 : 1;
        })->values();
    }
}
