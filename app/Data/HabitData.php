<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\AbstinenceHabit\AbstinenceHabitData;
use App\Data\CountHabit\CountHabitData;
use App\Data\DailyHabit\DailyHabitData;
use App\Enums\HabitColor;
use App\Enums\HabitIcon;
use App\Enums\HabitStatus;
use App\Enums\HabitType;
use App\Models\Habit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

final class HabitData extends Data
{
    /**
     * @param Collection<int, HabitNoteData>|Lazy|null $notes
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public ?HabitColor $color,
        public ?HabitIcon $icon,
        public HabitType $type,
        public HabitStatus $status,
        public int $streak = 123,
        public null|AbstinenceHabitData|CountHabitData|DailyHabitData|Lazy $habitable = null,
        public null|CarbonImmutable|Lazy $starts_at = null,
        public null|CarbonImmutable|Lazy $ends_at = null,
        public null|string|Lazy $started_at = null,
        public null|CarbonImmutable|Lazy $ended_at = null,
        public bool|Lazy $has_started = false,
        public bool|Lazy $is_public = false,
        public Collection|Lazy|null $notes = null,
        public int|Lazy $notes_count = 0,
    ) {}

    public static function fromModel(Habit $habit): self
    {
        $parts = explode(' ', $habit->title);
        $text = count($parts) > 1
            ? mb_strtoupper($parts[0][0].$parts[1][0])
            : mb_strtoupper(mb_substr($habit->title, 0, 2));

        return new self(
            id: $habit->id,
            name: $habit->title,
            description: $habit->description,
            color: $habit->color,
            icon: $habit->icon,
            type: $habit->getType(),
            status: HabitStatus::Completed,
            streak: 123, // TODO: Calculate status: if abstinence then always "Clean", other types Daily and Count depending on completion
            habitable: Lazy::create(fn () => $habit->getHabitableResource()),
            starts_at: Lazy::create(fn () => $habit->starts_at),
            ends_at: Lazy::create(fn () => $habit->ends_at),
            started_at: Lazy::create(fn () => $habit->started_at->format('M j, Y')),
            ended_at: Lazy::create(fn () => $habit->ended_at),
            has_started: Lazy::create(fn () => isset($habit->starts_at) && $habit->starts_at < now() || isset($habit->started_at)),
            is_public: Lazy::create(fn () => $habit->is_public),
            notes: Lazy::create(fn () => HabitNoteData::collect($habit->notes)),
            notes_count: Lazy::create(fn () => $habit->notes_count),
        );
    }
}
