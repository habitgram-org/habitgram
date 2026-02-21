<?php

declare(strict_types=1);

namespace App\DTOs\Habit;

use App\Enums\UnitType;
use Spatie\LaravelData\Dto;

final class CreateAbstinenceHabitDTO extends Dto
{
    public function __construct(
        public ?int $goal,
        public ?UnitType $goal_unit,
    ) {}
}
