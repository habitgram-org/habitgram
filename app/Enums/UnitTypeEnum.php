<?php

declare(strict_types=1);

namespace App\Enums;

enum UnitTypeEnum: int
{
    case Meters = 1;
    case Kilometers = 2;
    case Pages = 3;
    case Times = 4;
}
