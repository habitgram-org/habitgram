<?php

declare(strict_types=1);

namespace App\Enums;

enum HabitStatus: string
{
    case Completed = 'completed';
    case Pending = 'pending';
    case Failed = 'failed';
    case Active = 'active';
}
