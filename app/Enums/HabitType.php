<?php

declare(strict_types=1);

namespace App\Enums;

enum HabitType: string
{
    use EnumHelperTrait;

    case Abstinence = 'abstinence';
    case Daily = 'daily';
    case Count = 'count';
}
