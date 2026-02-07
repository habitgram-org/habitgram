<?php

declare(strict_types=1);

namespace App\Http\Resources\DailyHabit;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class DailyHabitEntryResource extends Resource
{
    public function __construct(
        public string $date,
        public Optional|string $id,
        public Optional|bool $is_succeeded,
        public Optional|bool $is_future,
        public Optional|CarbonImmutable $created_at,
    ) {}
}
