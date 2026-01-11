<?php

declare(strict_types=1);

namespace App\Models\Count;

use App\Models\HabitEntryNote;
use App\Models\HabitParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property string $id
 * @property int $value
 * @property string $count_habit_id
 * @property string $habit_participant_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read CountHabit $countHabit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HabitEntryNote> $notes
 * @property-read int|null $notes_count
 * @property-read User|null $user
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

    /**
     * @return MorphMany<HabitEntryNote, $this>
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(HabitEntryNote::class, 'notable');
    }

    /**
     * @return HasOneThrough<User, HabitParticipant, $this>
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            related: User::class,
            through: HabitParticipant::class,
            firstKey: 'id',
            secondKey: 'id',
            localKey: 'habit_participant_id',
            secondLocalKey: 'user_id',
        );
    }
}
