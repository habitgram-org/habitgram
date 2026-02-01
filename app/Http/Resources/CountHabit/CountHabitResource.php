<?php

declare(strict_types=1);

namespace App\Http\Resources\CountHabit;

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
     * @param  Collection<int>  $quick_amounts
     */
    public function __construct(
        public string $id,
        public string $total,
        public string $unit,
        public DataCollection $entries,
        /** @var Collection<int> */
        public Collection $quick_amounts,
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
        return new self(
            id: $countHabit->id,
            total: Number::format($countHabit->getAttribute('entries_sum_amount'), locale: 'sv'),
            unit: $countHabit->unit->name,
            entries: CountHabitEntryResource::collect($countHabit->entries, DataCollection::class),
            quick_amounts: $countHabit->entries->map(fn ($entry) => $entry->amount)->take(3)->unique()->values(),
            notes_count: $countHabit->entries->filter(fn ($entry) => ! empty($entry->note))->count(),
            streak_days: 123, // TODO: Calculate streak days
            average_per_day: (int) $countHabit->getAttribute('entries_avg_amount'), // TODO: Calculate average per day, not per entries
            goal: isset($countHabit->goal) ? Number::format($countHabit->goal, locale: 'sv') : Optional::create(),
            progress: $countHabit->progress ?? Optional::create(),
            remaining_amount: $countHabit->remaining_amount ?? Optional::create(),
            created_at: $countHabit->created_at?->toDayDateTimeString(),
        );
    }
}
