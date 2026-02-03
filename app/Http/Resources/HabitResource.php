<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\HabitType;
use App\Http\Resources\AbstinenceHabit\AbstinenceHabitResource;
use App\Http\Resources\CountHabit\CountHabitResource;
use App\Http\Resources\DailyHabit\DailyHabitResource;
use App\Models\Habit;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;

final class HabitResource extends Resource
{
    public function __construct(
        public string $id,
        public string $name,
        public Optional|string $description,
        public Optional|CountHabitResource|AbstinenceHabitResource|DailyHabitResource $habitable,
        public Optional|HabitType $type,
        public Optional|CarbonImmutable $starts_at,
        public Optional|CarbonImmutable $ends_at,
        public Optional|string $started_at,
        public Optional|CarbonImmutable $ended_at,
        public bool $has_started,
        public bool $is_public,
    ) {}

    public static function fromModel(Habit $habit): self
    {
        return new self(
            id: $habit->id,
            name: $habit->name,
            description: $habit->description ?? Optional::create(),
            habitable: isset($habit->habitable) ? $habit->getHabitableResource() : Optional::create(),
            type: isset($habit->habitable) ? $habit->getType() : Optional::create(),
            starts_at: $habit->starts_at ?? Optional::create(),
            ends_at: $habit->ends_at ?? Optional::create(),
            started_at: isset($habit->started_at) ? $habit->started_at->format('M j, Y') : Optional::create(),
            ended_at: $habit->ended_at ?? Optional::create(),
            has_started: (isset($habit->starts_at) && $habit->starts_at < now())
                || (isset($habit->started_at)),
            is_public: $habit->is_public,
        );
    }
}
