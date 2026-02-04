<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\HabitNote;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class HabitNoteResource extends Resource
{
    public function __construct(
        public string $id,
        public string $note,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(HabitNote $habitNote): self
    {
        return new self(
            id: $habitNote->id,
            note: $habitNote->note,
            created_at: $habitNote->created_at?->toDayDateTimeString() ?? Optional::create(),
        );
    }
}
