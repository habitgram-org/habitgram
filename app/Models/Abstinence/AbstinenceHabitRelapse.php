<?php

declare(strict_types=1);

namespace App\Models\Abstinence;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property \Carbon\CarbonImmutable $happened_at
 * @property string $abstinence_habit_id
 * @property string $habit_participant_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $reason
 * @property-read AbstinenceHabit $abstinenceHabit
 *
 * @method static \Database\Factories\Abstinence\AbstinenceHabitRelapseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse whereAbstinenceHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse whereHabitParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse whereHappenedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AbstinenceHabitRelapse whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class AbstinenceHabitRelapse extends Model
{
    /** @use HasFactory<\Database\Factories\Abstinence\AbstinenceHabitRelapseFactory> */
    use HasFactory, HasUuids;

    /**
     * @return BelongsTo<AbstinenceHabit, $this>
     */
    public function abstinenceHabit(): BelongsTo
    {
        return $this->belongsTo(AbstinenceHabit::class);
    }

    protected function casts(): array
    {
        return [
            'reason' => app()->environment('production') ? 'encrypted' : 'string',
            'happened_at' => 'immutable_datetime',
        ];
    }
}
