<?php

declare(strict_types=1);

namespace App\Actions\Habit;

use App\DTOs\Habit\CreateHabitDTO;
use App\Enums\HabitType;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Count\CountHabit;
use App\Models\Daily\DailyHabit;
use App\Models\Habit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateHabit
{
    /**
     * @throws Throwable
     */
    public function run(CreateHabitDTO $dto, ?User $user = null): Habit
    {
        return DB::transaction(function () use ($dto, $user) {
            $habit = new Habit();

            $habit->title = $dto->title;
            $habit->description = $dto->description;
            $habit->color = $dto->color;
            $habit->icon = $dto->icon;
            $habit->is_public = $dto->is_public;

            $habitable = match ($dto->type) {
                HabitType::Abstinence => $this->createAbstinenceHabit($dto),
                HabitType::Count => $this->createCountHabit($dto),
                HabitType::Daily => $this->createDailyHabit(),
            };

            $habit->habitable()->associate($habitable);
            $habit->save();

            // Create participant for the user
            $currentUser = $user ?? Auth::user();
            if ($currentUser) {
                $habit->users()->attach($currentUser->id, ['is_leader' => true]);
            }

            return $habit;
        });
    }

    private function createAbstinenceHabit(CreateHabitDTO $dto): AbstinenceHabit
    {
        $abstinenceHabit = new AbstinenceHabit();
        $abstinenceHabit->goal = $dto->abstinence?->goal;
        $abstinenceHabit->goal_unit = $dto->abstinence?->goal_unit;
        $abstinenceHabit->save();

        return $abstinenceHabit;
    }

    private function createCountHabit(CreateHabitDTO $dto): CountHabit
    {
        $countHabit = new CountHabit();
        $countHabit->goal = $dto->count?->target;
        $countHabit->unit = $dto->count?->unit_type;
        $countHabit->save();

        return $countHabit;
    }

    private function createDailyHabit(): DailyHabit
    {
        $dailyHabit = new DailyHabit();
        $dailyHabit->save();

        return $dailyHabit;
    }
}
