<?php

declare(strict_types=1);

namespace App\Data\CountHabit;

use App\Data\EntryNoteData;
use App\Models\Count\CountHabit;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

final class CountHabitData extends Data
{
    /**
     * @param  Collection<int, CountHabitEntryData>  $entries
     * @param  Collection<int, EntryNoteData>  $notes
     * @param  Collection<int, int>  $quick_amounts
     */
    public function __construct(
        public string $id,
        public string|Lazy $total,
        public string|Lazy $unit,
        public Collection|Lazy $entries,
        public Collection|Lazy $quick_amounts,
        public Collection|Lazy $notes,
        public int|Lazy $notes_count,
        public int|Lazy $streak_days,
        public int|Lazy $average_per_day,
        public null|string|Lazy $goal,
        public null|int|Lazy $progress,
        public null|int|Lazy $remaining_amount,
        public null|string|Lazy $created_at,
    ) {}

    public static function fromModel(CountHabit $countHabit): self
    {
        $quickAmounts = $countHabit->entries()
            ->select(['amount'])
            ->groupBy('amount')
            ->orderByRaw('COUNT(amount) DESC')
            ->limit(3)
            ->pluck('amount')
            ->values();

        $averagePerDay = $countHabit->entries()
            ->selectRaw('SUM(amount) / COUNT(DISTINCT DATE(created_at)) as average_per_day')
            ->value('average_per_day');

        return new self(
            id: $countHabit->id,
            total: Lazy::create(fn () => Number::format($countHabit->getAttribute('entries_sum_amount'), locale: 'sv')),
            unit: Lazy::create(fn () => $countHabit->unit->name),
            entries: Lazy::create(fn () => CountHabitEntryData::collect(
                items: $countHabit->entries()->latest()->limit(5)->get(),
            )),
            quick_amounts: Lazy::create(fn () => $quickAmounts),
            notes: Lazy::create(fn () => EntryNoteData::collect(
                items: $countHabit->entries()->whereNotNull('note')->latest()->limit(5)->get(),
            )),
            notes_count: Lazy::create(fn () => $countHabit->entries->filter(fn ($entry) => ! empty($entry->note))->count()),
            streak_days: Lazy::create(fn () => 0), // TODO: Calculate streak days
            average_per_day: Lazy::create(fn () => $averagePerDay),
            goal: Lazy::create(fn () => isset($countHabit->goal) ? Number::format($countHabit->goal, locale: 'sv') : null),
            progress: Lazy::create(fn () => $countHabit->progress),
            remaining_amount: Lazy::create(fn () => $countHabit->remaining_amount),
            created_at: Lazy::create(fn () => $countHabit->created_at?->toDayDateTimeString()),
        );
    }
}
