<?php

declare(strict_types=1);

namespace App\Models\Daily;

use App\Models\Habit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DailyHabitEntry> $entries
 * @property-read int|null $entries_count
 * @property-read Habit|null $habit
 *
 * @method static \Database\Factories\Daily\DailyHabitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class DailyHabit extends Model
{
    /** @use HasFactory<\Database\Factories\Daily\DailyHabitFactory> */
    use HasFactory, HasUuids;

    /**
     * @return MorphOne<Habit>
     */
    public function habit(): MorphOne
    {
        return $this->morphOne(Habit::class, 'habitable');
    }

    /**
     * @return HasMany<DailyHabitEntry, $this>
     */
    public function entries(): HasMany
    {
        return $this->hasMany(DailyHabitEntry::class);
    }
}
