<?php

declare(strict_types=1);

namespace App\Actions\Habit;

use App\DTOs\Habit\CreateHabitDTO;
use App\Enums\HabitType;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Count\CountHabit;
use App\Models\Daily\DailyHabit;
use App\Models\Habit;
use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateHabit
{
    /**
     * @throws Throwable
     */
    public function run(CreateHabitDTO $dto): Habit
    {
        return DB::transaction(function () use ($dto) {
            $habit = new Habit();

            $habit->title = $dto->title;
            $habit->description = $dto->description;
            $habit->color = $dto->color;
            $habit->icon = $dto->icon;
            $habit->is_public = $dto->is_public;

            $habitable = match ($dto->type) {
                HabitType::Abstinence => $this->createAbstinenceHabit(),
                HabitType::Count => $this->createCountHabit(),
                HabitType::Daily => $this->createDailyHabit(),
            };

            $habit->habitable()->associate($habitable);
            $habit->save();

            // TODO: create participant for the user

            return $habit;
        });
    }

    private function createAbstinenceHabit(): AbstinenceHabit
    {
        return AbstinenceHabit::create();
    }

    private function createCountHabit(): CountHabit
    {
        return CountHabit::create();
    }

    private function createDailyHabit(): DailyHabit
    {
        return DailyHabit::create();
    }
}
