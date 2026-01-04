<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property string $id
 * @property string $habit_id
 * @property string $user_id
 * @property bool $is_leader
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant whereHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant whereIsLeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitParticipant whereUserId($value)
 *
 * @mixin \Eloquent
 */
final class HabitParticipant extends Pivot
{
    /** @use HasFactory<\Database\Factories\HabitParticipantFactory> */
    use HasFactory, HasUuids;

    /**
     * @return BelongsTo<Habit, $this>
     */
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
       return $this->belongsTo(User::class);
    }
}
