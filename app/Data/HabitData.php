<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\AbstinenceHabit\AbstinenceHabitData;
use App\Data\CountHabit\CountHabitData;
use App\Data\DailyHabit\DailyHabitData;
use App\Enums\HabitType;
use App\Models\Habit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

final class HabitData extends Data
{
    /**
     * @param  Collection<int, HabitNoteData>|Lazy  $notes
     */
    public function __construct(
        public string $id,
        public string $name,
        public HabitType $type,
        public string|Lazy $image,
        public null|string|Lazy $description,
        public null|AbstinenceHabitData|CountHabitData|DailyHabitData|Lazy $habitable,
        public null|CarbonImmutable|Lazy $starts_at,
        public null|CarbonImmutable|Lazy $ends_at,
        public null|string|Lazy $started_at,
        public null|CarbonImmutable|Lazy $ended_at,
        public bool|Lazy $has_started,
        public bool|Lazy $is_public,
        public Collection|Lazy $notes,
        public int|Lazy $notes_count,
    ) {}

    public static function fromModel(Habit $habit): self
    {
        $parts = explode(' ', $habit->name);
        $text = count($parts) > 1
            ? mb_strtoupper($parts[0][0].$parts[1][0])
            : mb_strtoupper(mb_substr($habit->name, 0, 2));

        return new self(
            id: $habit->id,
            name: $habit->name,
            type: $habit->getType(),
            image: Lazy::create(fn () => radiance()
                ->seed($habit->id)
                ->text($text)
                ->textShadow(2)
                ->square()
                ->toBase64()),
            description: Lazy::create(fn () => $habit->description),
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
