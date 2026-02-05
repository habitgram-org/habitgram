<?php

declare(strict_types=1);

namespace App\Models\Abstinence;

use App\Enums\UnitType;
use App\Models\Habit;
use App\Models\HabitNote;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use LogicException;

/**
 * @property string $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int|null $goal
 * @property UnitType|null $goal_unit
 * @property-read mixed $duration
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AbstinenceHabitRelapse> $entries
 * @property-read int|null $entries_count
 * @property-read mixed $goal_current
 * @property-read mixed $goal_milliseconds
 * @property-read Habit|null $habit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HabitNote> $notes
 * @property-read int|null $notes_count
 * @property-read mixed $progress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AbstinenceHabitRelapse> $relapses
 * @property-read int|null $relapses_count
 * @property-read mixed $remaining
 *
 * @method static \Database\Factories\Abstinence\AbstinenceHabitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereGoalUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class AbstinenceHabit extends Model
{
    /** @use HasFactory<\Database\Factories\Abstinence\AbstinenceHabitFactory> */
    use HasFactory, HasUuids;

    protected $casts = [
        'goal_unit' => UnitType::class,
    ];

    /**
     * @return MorphOne<Habit, $this>
     */
    public function habit(): MorphOne
    {
        return $this->morphOne(Habit::class, 'habitable');
    }

    /**
     * @return HasMany<AbstinenceHabitRelapse, $this>
     */
    public function relapses(): HasMany
    {
        return $this->hasMany(AbstinenceHabitRelapse::class)->latest();
    }

    /**
     * Point to relapses() method in order to load habitable entries on other models like: CountHabit, DailyHabit
     *
     * @return HasMany<AbstinenceHabitRelapse, $this>
     */
    public function entries(): HasMany
    {
        return $this->relapses();
    }

    /**
     * @return MorphMany<HabitNote, $this>
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(HabitNote::class, 'habitable');
    }

    /**
     * Duration from last relapse or started at in milliseconds
     *
     * @return Attribute<int, void>
     */
    public function duration(): Attribute
    {
        /** @var AbstinenceHabitRelapse|null $relapse */
        $relapse = $this->relapses()->first();

        return Attribute::make(
            get: fn () => (int) ($relapse?->happened_at->diffInMilliseconds()
                ?? $this->habit->started_at->diffInMilliseconds()),
        );
    }

    /**
     * Return goal always in milliseconds
     *
     * @return Attribute<int, void>
     */
    public function goalMilliseconds(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->goal_unit) {
                UnitType::Seconds => $this->goal * 1000,
                UnitType::Minutes => $this->goal * 60 * 1000,
                UnitType::Hours => $this->goal * 60 * 60 * 1000,
                default => throw new LogicException('Goal unit type should either: Seconds, Minutes or Hours.'),
            },
        );
    }

    /**
     * @return Attribute<int, void>
     */
    public function goalCurrent(): Attribute
    {
        return Attribute::make(
            get: fn () => (int) match ($this->goal_unit) {
                UnitType::Seconds => $this->duration / 1000,
                UnitType::Minutes => $this->duration / (1000 * 60),
                UnitType::Hours => $this->duration / (1000 * 60 * 60),
                default => throw new LogicException('Goal unit type should either: Seconds, Minutes or Hours.'),
            },
        );
    }

    /**
     * @return Attribute<int|null, void>
     */
    public function progress(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->goal) ? (int) ($this->duration / $this->goalMilliseconds * 100) : null,
        );
    }

    /**
     * @return Attribute<int|null, void>
     */
    public function remaining(): Attribute
    {
        return Attribute::make(
            get: fn () => (int) match ($this->goal_unit) {
                UnitType::Seconds => ($this->goalMilliseconds - $this->duration) / 1000,
                UnitType::Minutes => ($this->goalMilliseconds - $this->duration) / (1000 * 60),
                UnitType::Hours => ($this->goalMilliseconds - $this->duration) / (1000 * 60 * 60),
                default => throw new LogicException('Goal unit type should either: Seconds, Minutes or Hours.'),
            },
        );
    }
}
