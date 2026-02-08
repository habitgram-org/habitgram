<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Count\CountHabitEntry;
use App\Models\Daily\DailyHabitEntry;
use Spatie\LaravelData\Data;

final class EntryNoteData extends Data
{
    public function __construct(
        public string $note,
        public ?string $created_at,
    ) {}

    public static function fromModel(CountHabitEntry|DailyHabitEntry $entry): self
    {
        return new self(
            note: $entry->note,
            created_at: $entry->created_at?->shortRelativeDiffForHumans(),
        );
    }
}
