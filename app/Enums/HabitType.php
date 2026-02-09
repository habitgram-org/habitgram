<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Count\CountHabit;
use App\Models\Daily\DailyHabit;

enum HabitType: string
{
    use EnumHelperTrait;

    case Abstinence = 'abstinence';
    case Daily = 'daily';
    case Count = 'count';

    public function getModel(): string
    {
        return match ($this) {
            self::Abstinence => AbstinenceHabit::class,
            self::Daily => DailyHabit::class,
            self::Count => CountHabit::class,
        };
    }
}
