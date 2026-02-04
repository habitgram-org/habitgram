<?php

declare(strict_types=1);

namespace App\Http\Resources\AbstinenceHabit;

use App\Http\Resources\EntryNoteResource;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\User;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class AbstinenceHabitResource extends Resource
{
    /**
     * @param  DataCollection<int, AbstinenceHabitEntryResource>  $relapses
     */
    public function __construct(
        public string $id,
        public DataCollection $relapses,
        public int $relapses_count,
        public Optional|string $created_at,
        public int $max_streak_days,
        public string $max_streak_start,
        public string $max_streak_end,
        public int $duration,
    ) {}

    public static function fromModel(AbstinenceHabit $abstinenceHabit, ?User $user = null): self
    {
        $relapses = AbstinenceHabitEntryResource::collect(
            items: $abstinenceHabit->relapses,
            into: DataCollection::class,
        );

        //        if ($user instanceof User) {
        //            $participantId = $abstinenceHabit->habit
        //                ?->participants()
        //                ->where('user_id', $user->id)
        //                ->value('id');
        //
        //            if ($participantId) {
        //                $notes = EntryNoteResource::collect(
        //                    items: $abstinenceHabit->notes()
        //                        ->where('habit_participant_id', $participantId)
        //                        ->latest()
        //                        ->limit(5)
        //                        ->get(),
        //                    into: DataCollection::class,
        //                );
        //
        //                $notesCount = $abstinenceHabit->notes()
        //                    ->where('habit_participant_id', $participantId)
        //                    ->count();
        //            }
        //        }

        return new self(
            id: $abstinenceHabit->id,
            relapses: $relapses,
            relapses_count: $abstinenceHabit->relapses_count,
            created_at: $abstinenceHabit->created_at?->toDayDateTimeString(),
            max_streak_days: 159,
            max_streak_start: CarbonImmutable::createFromDate(2022, 6, 12)->toDateString(),
            max_streak_end: CarbonImmutable::createFromDate(2022, 11, 17)->toDateString(),
            duration: $abstinenceHabit->duration,
        );
    }
}
