<?php

declare(strict_types=1);

namespace App\Models\Count;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property int $value
 * @property string $count_habit_id
 * @property string $habit_participant_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read CountHabit $countHabit
 *
 * @method static \Database\Factories\Count\CountHabitEntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry whereCountHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry whereHabitParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountHabitEntry whereValue($value)
 *
 * @mixin \Eloquent
 */
final class CountHabitEntry extends Model
{
    /** @use HasFactory<\Database\Factories\Count\CountHabitEntryFactory> */
    use HasFactory, HasUuids;

    /**
     * @return BelongsTo<CountHabit, $this>
     */
    public function countHabit(): BelongsTo
    {
        return $this->belongsTo(CountHabit::class);
    }
}
