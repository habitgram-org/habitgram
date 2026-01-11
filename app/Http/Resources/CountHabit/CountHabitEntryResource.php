<?php

declare(strict_types=1);

namespace App\Http\Resources\CountHabit;

use App\Http\Resources\HabitEntryNoteResource;
use App\Models\Count\CountHabitEntry;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class CountHabitEntryResource extends Resource
{
    /**
     * @param  DataCollection<int, HabitEntryNoteResource>  $notes
     */
    public function __construct(
        public string $id,
        public int $value,
        public string $by,
        public DataCollection $notes,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(CountHabitEntry $model): self
    {
        return new self(
            id: $model->id,
            value: $model->value,
            by: $model->user->name,
            notes: HabitEntryNoteResource::collect($model->notes, DataCollection::class),
            created_at: $model->created_at?->toDayDateTimeString(),
        );
    }
}
