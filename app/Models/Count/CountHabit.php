<?php

declare(strict_types=1);

namespace App\Models\Count;

use App\Models\Habit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string $id
 * @property int $unit_type
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CountHabitEntry> $entries
 * @property-read int|null $entries_count
 * @property-read Habit|null $habit
 *
 * @method static \Database\Factories\Count\CountHabitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabit whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class CountHabit extends Model
{
    /** @use HasFactory<\Database\Factories\Count\CountHabitFactory> */
    use HasFactory, HasUuids;

    /**
     * @return MorphOne<Habit>
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
}
