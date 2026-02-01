<?php

declare(strict_types=1);

namespace App\Actions\Habit\Count\Entry;

use App\DTOs\Habit\Count\Entry\CreateCountHabitEntryDTO;
use App\Models\Count\CountHabit;
use App\Models\Count\CountHabitEntry;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class CreateCountHabitEntry
{
    public function run(CountHabit $countHabit, User $user, CreateCountHabitEntryDTO $dto): void
    {
        DB::transaction(function () use ($countHabit, $user, $dto): void {
            $entry = new CountHabitEntry();
            $entry->amount = $dto->amount;
            $entry->note = $dto->note;
            $entry->habit_participant_id = $countHabit->habit
                ->participants()
                ->where('user_id', $user->id)
                ->firstOrFail()
                ->id;
            $countHabit->entries()->save($entry);
        });
    }
}
