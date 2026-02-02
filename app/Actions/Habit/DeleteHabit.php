<?php

declare(strict_types=1);

namespace App\Actions\Habit;

use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Count\CountHabit;
use App\Models\Daily\DailyHabit;
use App\Models\Habit;
use Illuminate\Support\Facades\DB;
use Throwable;

final class DeleteHabit
{
    /**
     * @throws Throwable
     */
    public function run(Habit $habit): void
    {
        DB::transaction(function () use ($habit): void {
            /** @var AbstinenceHabit|CountHabit|DailyHabit $habitable */
            $habitable = $habit->habitable();
            $habitable->entries()->delete();
            $habitable->delete();
            $habit->delete();
        });
    }
}
