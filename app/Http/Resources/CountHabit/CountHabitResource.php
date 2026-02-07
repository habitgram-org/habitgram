<?php

declare(strict_types=1);

namespace App\Http\Resources\CountHabit;

use App\Http\Resources\EntryNoteResource;
use App\Models\Count\CountHabit;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class CountHabitResource extends Resource
{
    /**
     * @param  DataCollection<int, CountHabitEntryResource>  $entries
     * @param  DataCollection<int, EntryNoteResource>  $notes
     * @param  Collection<int, int>  $quick_amounts
     */
    public function __construct(
        public string $id,
        public string $total,
        public string $unit,
        public DataCollection $entries,
        /** @var Collection<int, int> */
        public Collection $quick_amounts,
        public DataCollection $notes,
        public int $notes_count,
        public int $streak_days,
        public int $average_per_day,
        public Optional|string $goal,
        public Optional|int $progress,
        public Optional|int $remaining_amount,
        public Optional|string $created_at,
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
            entries: CountHabitEntryResource::collect(
                items: $countHabit->entries()->latest()->limit(5)->get(),
                into: DataCollection::class,
            ),
            quick_amounts: $quickAmounts,
            notes: EntryNoteResource::collect(
                items: $countHabit->entries()->whereNotNull('note')->latest()->limit(5)->get(),
                into: DataCollection::class,
            ),
            notes_count: $countHabit->entries->filter(fn ($entry) => ! empty($entry->note))->count(),
            streak_days: 0, // TODO: Calculate streak days
            average_per_day: $averagePerDay,
            goal: isset($countHabit->goal) ? Number::format($countHabit->goal, locale: 'sv') : Optional::create(),
            progress: $countHabit->progress ?? Optional::create(),
            remaining_amount: $countHabit->remaining_amount ?? Optional::create(),
            created_at: $countHabit->created_at?->toDayDateTimeString(),
        );
    }
}
