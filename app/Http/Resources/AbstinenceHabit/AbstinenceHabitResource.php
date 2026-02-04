<?php

declare(strict_types=1);

namespace App\Http\Resources\AbstinenceHabit;

use App\Http\Resources\EntryNoteResource;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\User;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class AbstinenceHabitResource extends Resource
{
    /**
     * @param  DataCollection<int, AbstinenceHabitEntryResource>  $entries
     * @param  DataCollection<int, EntryNoteResource>  $notes
     */
    public function __construct(
        public string $id,
        public DataCollection $entries,
        public DataCollection $notes,
        public int $notes_count,
        public Optional|string $created_at,
    ) {}

    public static function fromModel(AbstinenceHabit $abstinenceHabit, ?User $user = null): self
    {
        $entries = AbstinenceHabitEntryResource::collect(
            items: $abstinenceHabit->entries,
            into: DataCollection::class,
        );

        $notes = EntryNoteResource::collect(
            items: [],
            into: DataCollection::class,
        );
        $notesCount = 0;

        if ($user instanceof User) {
            $participantId = $abstinenceHabit->habit
                ?->participants()
                ->where('user_id', $user->id)
                ->value('id');

            if ($participantId) {
                $notes = EntryNoteResource::collect(
                    items: $abstinenceHabit->notes()
                        ->where('habit_participant_id', $participantId)
                        ->latest()
                        ->limit(5)
                        ->get(),
                    into: DataCollection::class,
                );

                $notesCount = $abstinenceHabit->notes()
                    ->where('habit_participant_id', $participantId)
                    ->count();
            }
        }

        return new self(
            id: $abstinenceHabit->id,
            entries: $entries,
            notes: $notes,
            notes_count: $notesCount,
            created_at: $abstinenceHabit->created_at?->toDayDateTimeString(),
        );
    }
}
