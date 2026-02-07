<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $note
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $habit_id
 * @property string $habit_participant_id
 * @property-read Habit $habit
 * @property-read HabitParticipant $habitParticipant
 *
 * @method static \Database\Factories\HabitNoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereHabitParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class HabitNote extends Model
{
    /** @use HasFactory<\Database\Factories\HabitNoteFactory> */
    use HasFactory, HasUuids;

    /**
     * @return BelongsTo<Habit, $this>
     */
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }

    /**
     * @return BelongsTo<HabitParticipant, $this>
     */
    public function habitParticipant(): BelongsTo
    {
        return $this->belongsTo(HabitParticipant::class);
    }

    protected function casts(): array
    {
        return [
            'note' => app()->environment('production') ? 'encrypted' : 'string',
        ];
    }
}
