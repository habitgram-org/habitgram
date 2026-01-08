<?php

declare(strict_types=1);

namespace App\Models\Daily;

use App\Models\HabitEntryNote;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property string $id
 * @property string|null $failed_at
 * @property string|null $succeeded_at
 * @property string $daily_habit_id
 * @property string $habit_participant_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read DailyHabit $dailyHabit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HabitEntryNote> $notes
 * @property-read int|null $notes_count
 *
 * @method static \Database\Factories\Daily\DailyHabitEntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry whereDailyHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry whereFailedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry whereHabitParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry whereSucceededAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyHabitEntry whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class DailyHabitEntry extends Model
{
    /** @use HasFactory<\Database\Factories\Daily\DailyHabitEntryFactory> */
    use HasFactory, HasUuids;

    /**
     * @return BelongsTo<DailyHabit, $this>
     */
    public function dailyHabit(): BelongsTo
    {
        return $this->belongsTo(DailyHabit::class);
    }

    /**
     * @return MorphMany<HabitEntryNote, $this>
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(HabitEntryNote::class, 'notable');
    }
}
