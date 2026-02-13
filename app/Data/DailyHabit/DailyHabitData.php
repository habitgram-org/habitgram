<?php

declare(strict_types=1);

namespace App\Data\DailyHabit;

use App\Models\Daily\DailyHabit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

final class DailyHabitData extends Data
{
    private const int DAYS_IN_LEAP_YEAR = 366;

    private const int DAYS_IN_USUAL_YEAR = 365;

    /**
     * @param  Collection<int, DailyHabitEntryData>|Lazy  $entries
     */
    public function __construct(
        public string $id,
        public Collection|Lazy $entries,
        public null|string|Lazy $created_at,
        public int|Lazy $longest_streak_days,
        public int|Lazy $current_streak_days,
        public int|Lazy $total_completions,
        public int|Lazy $completion_rate,
        public string|Lazy $today_date,
        public string|Lazy $max_streak_start,
        public string|Lazy $max_streak_end,
        public bool|Lazy $is_today_completed,
        public int|Lazy $year,
        public int|Lazy $completed_days_in_year,
    ) {}

    public static function fromModel(DailyHabit $dailyHabit): self
    {
        return new self(
            id: $dailyHabit->id,
            entries: Lazy::create(fn () => self::getDailyEntries($dailyHabit)),
            created_at: Lazy::create(fn () => $dailyHabit->created_at?->toDayDateTimeString()),
            longest_streak_days: Lazy::create(fn () => 999),
            current_streak_days: Lazy::create(fn () => 0),
            total_completions: Lazy::create(fn () => 0),
            completion_rate: Lazy::create(fn () => 0),
            today_date: Lazy::create(fn () => now()->toFormattedDateString()),
            max_streak_start: Lazy::create(fn () => CarbonImmutable::createFromDate(2022, 6, 12)->toDateString()),
            max_streak_end: Lazy::create(fn () => CarbonImmutable::createFromDate(2022, 11, 17)->toDateString()),
            is_today_completed: Lazy::create(fn () => $dailyHabit->is_today_completed),
            year: Lazy::create(fn () => 2025),
            completed_days_in_year: Lazy::create(fn () => 999),
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
