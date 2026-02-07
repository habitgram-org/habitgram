<?php

declare(strict_types=1);

namespace App\Http\Resources\DailyHabit;

use App\Models\Daily\DailyHabit;
use App\Models\Daily\DailyHabitEntry;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class DailyHabitResource extends Resource
{
    private const int DAYS_IN_LEAP_YEAR = 366;

    private const int DAYS_IN_USUAL_YEAR = 365;

    /**
     * @param  Collection<int, DailyHabitEntryResource>  $entries
     */
    public function __construct(
        public string $id,
        public Collection $entries,
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
            entries: self::getDailyEntries($dailyHabit->entries),
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
     * @param  EloquentCollection<int, DailyHabitEntry>  $existingEntries
     * @return Collection<int, DailyHabitEntryResource>
     */
    private static function getDailyEntries(EloquentCollection $existingEntries): Collection
    {
        /** @var Collection<int, DailyHabitEntryResource> $entries */
        $entries = collect();
        foreach ($existingEntries as $entry) {
            // Calculating and pushing either completed or missed days
            $entries->push(DailyHabitEntryResource::from([
                'id' => $entry->id,
                'is_succeeded' => (bool) ($entry->succeeded_at ?? $entry->failed_at),
                'is_future' => false,
                'date' => $entry->created_at?->toDayDateTimeString(),
                'created_at' => $entry->created_at ?? Optional::create(),
            ]));
        }

        // Calculating the "none" and future days
        collect(range(1, now()->isLeapYear() ? self::DAYS_IN_LEAP_YEAR : self::DAYS_IN_USUAL_YEAR))
            ->diff($entries->map(fn (DailyHabitEntryResource $e) => $e->created_at->dayOfYear)->all())
            ->each(function (int $value) use ($entries): void {
                $date = now()->setYear(2025)->startOfYear()->setDay($value);
                $entries->push(DailyHabitEntryResource::from([
                    'date' => $date->toDayDateTimeString(),
                    'is_future' => $date->isFuture(),
                    'created_at' => $date,
                ]));
            });

        return $entries->sort(function (DailyHabitEntryResource $a, DailyHabitEntryResource $b) {
            return $a->created_at->dayOfYear < $b->created_at->dayOfYear ? -1 : 1;
        })->values();
    }
}
