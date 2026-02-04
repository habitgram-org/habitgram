<?php

declare(strict_types=1);

namespace App\Actions\Habit\Abstinence\Relapse;

use App\DTOs\Habit\Abstinence\Relapse\CreateAbstinenceHabitRelapseDTO;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Abstinence\AbstinenceHabitRelapse;
use App\Models\HabitParticipant;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

final class CreateAbstinenceHabitRelapse
{
    public function run(
        CreateAbstinenceHabitRelapseDTO $dto,
        AbstinenceHabit $abstinenceHabit,
        HabitParticipant $participant
    ): void {
        DB::transaction(function () use ($dto, $abstinenceHabit, $participant): void {
            $relapse = new AbstinenceHabitRelapse();
            $relapse->reason = $dto->reason;
            $relapse->happened_at = CarbonImmutable::now();
            $relapse->habit_participant_id = $participant->id;

            $abstinenceHabit->relapses()->save($relapse);
        });
    }
}
