<?php

declare(strict_types=1);

namespace App\DTOs\Habit;

use App\Enums\UnitType;
use Spatie\LaravelData\Dto;

final class CreateCountHabitDTO extends Dto
{
    public function __construct(
        public ?int $target,
        public ?UnitType $unit_type,
    ) {}
}
