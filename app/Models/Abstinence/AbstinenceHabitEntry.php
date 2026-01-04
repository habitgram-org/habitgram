<?php

declare(strict_types=1);

namespace App\Models\Abstinence;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $happened_at
 * @property string $abstinence_habit_id
 * @property string $habit_participant_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read AbstinenceHabit $abstinenceHabit
 *
 * @method static \Database\Factories\Abstinence\AbstinenceHabitEntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry whereAbstinenceHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry whereHabitParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry whereHappenedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitEntry whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class AbstinenceHabitEntry extends Model
{
    /** @use HasFactory<\Database\Factories\Abstinence\AbstinenceHabitEntryFactory> */
    use HasFactory, HasUuids;

    /**
     * @return BelongsTo<AbstinenceHabit, $this>
     */
    public function abstinenceHabit(): BelongsTo
    {
        return $this->belongsTo(AbstinenceHabit::class);
    }
}
