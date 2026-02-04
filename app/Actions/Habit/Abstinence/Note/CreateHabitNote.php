<?php

declare(strict_types=1);

namespace App\Actions\Habit\Abstinence\Note;

use App\DTOs\Habit\Abstinence\Note\CreateHabitNoteDTO;
use App\Models\Habit;
use App\Models\HabitNote;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class CreateHabitNote
{
    public function run(Habit $habit, User $user, CreateHabitNoteDTO $dto): void
    {
        DB::transaction(function () use ($habit, $user, $dto): void {
            $participantId = $habit
                ->participants()
                ->where('user_id', $user->id)
                ->firstOrFail()
                ->id;

            $note = new HabitNote();
            $note->note = $dto->note;
            $note->habit_participant_id = $participantId;

            $habit->notes()->save($note);
        });
    }
}
