<?php

declare(strict_types=1);

namespace App\Http\Resources\AbstinenceHabit;

use App\Models\Abstinence\AbstinenceHabit;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class AbstinenceHabitResource extends Resource
{
    /**
     * @param  DataCollection<int, AbstinenceHabitEntryResource>  $entries
     */
    public function __construct(
        public string $id,
        public DataCollection $entries,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(AbstinenceHabit $abstinenceHabit): self
    {
        return new self(
            id: $abstinenceHabit->id,
            entries: AbstinenceHabitEntryResource::collect(
                items: $abstinenceHabit->entries,
                into: DataCollection::class,
            ),
            created_at: $abstinenceHabit->created_at?->toDayDateTimeString(),
        );
    }
}
