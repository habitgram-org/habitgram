<?php

declare(strict_types=1);

namespace App\Models\Abstinence;

use App\Models\Habit;
use App\Models\HabitNote;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $duration
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AbstinenceHabitRelapse> $relapses
 * @property-read int|null $relapses_count
 * @property-read Habit|null $habit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HabitNote> $notes
 * @property-read int|null $notes_count
 *
 * @method static \Database\Factories\Abstinence\AbstinenceHabitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class AbstinenceHabit extends Model
{
    /** @use HasFactory<\Database\Factories\Abstinence\AbstinenceHabitFactory> */
    use HasFactory, HasUuids;

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
}
