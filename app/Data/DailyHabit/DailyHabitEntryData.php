<?php

declare(strict_types=1);

namespace App\Data\DailyHabit;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class DailyHabitEntryData extends Data
{
    public function __construct(
        public ?string $date,
        public ?string $id,
        public ?bool $is_succeeded,
        public ?bool $is_future,
        public ?CarbonImmutable $created_at,
    ) {}
}
