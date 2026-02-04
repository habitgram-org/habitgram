<?php

declare(strict_types=1);

namespace App\DTOs\Habit\Abstinence\Relapse;

use Spatie\LaravelData\Dto;

final class CreateAbstinenceHabitRelapseDTO extends Dto
{
    public function __construct(
        public string $reason,
    ) {}
}
