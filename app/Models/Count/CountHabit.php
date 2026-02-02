<?php

declare(strict_types=1);

namespace App\Models\Count;

use App\Enums\UnitType;
use App\Models\Habit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property UnitType $unit
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int|null $goal
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CountHabitEntry> $entries
 * @property-read int|null $entries_count
 * @property-read Habit|null $habit
 * @property-read mixed $progress
 * @property-read mixed $remaining_amount
 *
 * @method static \Database\Factories\Count\CountHabitFactory factory($count = null, $state = [])
 * @method static Builder<static>|CountHabit newModelQuery()
 * @method static Builder<static>|CountHabit newQuery()
 * @method static Builder<static>|CountHabit query()
 * @method static Builder<static>|CountHabit whereCreatedAt($value)
 * @method static Builder<static>|CountHabit whereDeletedAt($value)
 * @method static Builder<static>|CountHabit whereGoal($value)
 * @method static Builder<static>|CountHabit whereId($value)
 * @method static Builder<static>|CountHabit whereUnit($value)
 * @method static Builder<static>|CountHabit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class CountHabit extends Model
{
    /** @use HasFactory<\Database\Factories\Count\CountHabitFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $casts = [
        'unit' => UnitType::class,
    ];

    /**
     * @return MorphOne<Habit, $this>
     */
    public function habit(): MorphOne
    {
        return $this->morphOne(Habit::class, 'habitable');
    }

    /**
     * @return HasMany<CountHabitEntry, $this>
     */
    public function entries(): HasMany
    {
        return $this->hasMany(CountHabitEntry::class);
    }

    /**
     * @return Attribute<int|null, void>
     */
    public function progress(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->goal) ? (int) ((int) $this->getAttribute(
                'entries_sum_amount'
            ) / $this->goal * 100) : null,
        );
    }

    /**
     * @return Attribute<int|null, void>
     */
    public function remainingAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => isset($this->goal) ? (int) ($this->goal - $this->getAttribute('entries_sum_amount')) : null,
        );
    }
}
