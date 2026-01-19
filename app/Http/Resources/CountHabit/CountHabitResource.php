<?php

declare(strict_types=1);

namespace App\Http\Resources\CountHabit;

use App\Models\Count\CountHabit;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class CountHabitResource extends Resource
{
    /**
     * @param  DataCollection<int, CountHabitEntryResource>  $entries
     */
    public function __construct(
        public string $id,
        public Optional|int $total,
        public string $measurement_unit_type,
        public DataCollection $entries,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(CountHabit $model): self
    {
        return new self(
            id: $model->id,
            total: $model->getAttribute('entries_sum_value'),
            measurement_unit_type: $model->measurement_unit_type->name,
            entries: CountHabitEntryResource::collect($model->entries, DataCollection::class),
            created_at: $model->created_at?->toDayDateTimeString(),
        );
    }
}
