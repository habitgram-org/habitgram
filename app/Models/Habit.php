<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\HabitType;
use App\Http\Resources\AbstinenceHabit\AbstinenceHabitResource;
use App\Http\Resources\CountHabit\CountHabitResource;
use App\Http\Resources\DailyHabit\DailyHabitResource;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Count\CountHabit;
use App\Models\Daily\DailyHabit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use LogicException;

/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $starts_at
 * @property \Carbon\CarbonImmutable|null $ends_at
 * @property \Carbon\CarbonImmutable|null $started_at
 * @property \Carbon\CarbonImmutable|null $ended_at
 * @property string $habitable_type
 * @property string $habitable_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read CountHabit|AbstinenceHabit|DailyHabit $habitable
 * @property-read User|null $leader
 * @property-read HabitParticipant|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $participants
 * @property-read int|null $participants_count
 *
 * @method static \Database\Factories\HabitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereHabitableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereHabitableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class Habit extends Model
{
    /** @use HasFactory<\Database\Factories\HabitFactory> */
    use HasFactory, HasUuids;

    protected $casts = [
        'started_at' => 'immutable_datetime',
        'ended_at' => 'immutable_datetime',
        'starts_at' => 'immutable_datetime',
        'ends_at' => 'immutable_datetime',
    ];

    /**
     * @return MorphTo<CountHabit|AbstinenceHabit|DailyHabit, $this>
     */
    public function habitable(): MorphTo
    {
        return $this->morphTo('habitable');
    }

    /**
     * @return HasOneThrough<User, HabitParticipant, $this>
     */
    public function leader(): HasOneThrough
    {
        return $this->hasOneThrough(
            related: User::class,
            through: HabitParticipant::class,
            firstKey: 'habit_id',
            secondLocalKey: 'user_id'
        )->where('habit_participant.is_leader', true);
    }

    /**
     * @return BelongsToMany<User, $this, HabitParticipant>
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'habit_participant')->using(HabitParticipant::class);
    }

    public function getHabitableResource(): AbstinenceHabitResource|CountHabitResource|DailyHabitResource
    {
        return match ($this->habitable::class) {
            AbstinenceHabit::class => new AbstinenceHabitResource($this->habitable),
            CountHabit::class => new CountHabitResource($this->habitable),
            DailyHabit::class => new DailyHabitResource($this->habitable),
            default => throw new LogicException('Unhandled habitable type'),
        };
    }

    public function getType(): HabitType
    {
        return match ($this->habitable::class) {
            AbstinenceHabit::class => HabitType::Abstinence,
            CountHabit::class => HabitType::Count,
            DailyHabit::class => HabitType::Daily,
            default => throw new LogicException('Unhandled habitable type'),
        };
    }
}
