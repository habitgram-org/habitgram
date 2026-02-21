<?php

declare(strict_types=1);

namespace App\DTOs\Habit;

use App\Enums\HabitColor;
use App\Enums\HabitIcon;
use App\Enums\HabitType;
use Spatie\LaravelData\Dto;

final class CreateHabitDTO extends Dto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public HabitColor $color,
        public HabitIcon $icon,
        public HabitType $type,
        public bool $is_public,
        public ?CreateCountHabitDTO $count = null,
        public ?CreateAbstinenceHabitDTO $abstinence = null,
    ) {}
}
