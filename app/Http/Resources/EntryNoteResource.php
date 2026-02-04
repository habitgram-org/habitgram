<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Count\CountHabitEntry;
use App\Models\Daily\DailyHabitEntry;
use App\Models\HabitNote;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class EntryNoteResource extends Resource
{
    public function __construct(
        public string $note,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(CountHabitEntry|DailyHabitEntry|HabitNote $entry): self
    {
        return new self(
            note: $entry->note,
            created_at: $entry->created_at?->shortRelativeDiffForHumans() ?? Optional::create(),
        );
    }
}
