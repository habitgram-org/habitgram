<?php

declare(strict_types=1);

namespace App\Data\CountHabit;

use App\Data\EntryNoteData;
use App\Models\Count\CountHabit;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Spatie\LaravelData\Data;

final class CountHabitData extends Data
{
    /**
     * @param  Collection<int, CountHabitEntryData>  $entries
     * @param  Collection<int, EntryNoteData>  $notes
     * @param  Collection<int, int>  $quick_amounts
     */
    public function __construct(
        public string $id,
        public string $total,
        public string $unit,
        public Collection $entries,
        public Collection $quick_amounts,
        public Collection $notes,
        public int $notes_count,
        public int $streak_days,
        public int $average_per_day,
        public ?string $goal,
        public ?int $progress,
        public ?int $remaining_amount,
        public ?string $created_at,
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
            total: Number::format($countHabit->getAttribute('entries_sum_amount'), locale: 'sv'),
            unit: $countHabit->unit->name,
            entries: CountHabitEntryData::collect(
                items: $countHabit->entries()->latest()->limit(5)->get(),
            ),
            quick_amounts: $quickAmounts,
            notes: EntryNoteData::collect(
                items: $countHabit->entries()->whereNotNull('note')->latest()->limit(5)->get(),
            ),
            notes_count: $countHabit->entries->filter(fn ($entry) => ! empty($entry->note))->count(),
            streak_days: 0, // TODO: Calculate streak days
            average_per_day: $averagePerDay,
            goal: isset($countHabit->goal) ? Number::format($countHabit->goal, locale: 'sv') : null,
            progress: $countHabit->progress,
            remaining_amount: $countHabit->remaining_amount,
            created_at: $countHabit->created_at?->toDayDateTimeString(),
        );
    }
}
