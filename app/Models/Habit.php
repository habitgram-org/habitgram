<?php

declare(strict_types=1);

namespace App\Models;

use App\Data\AbstinenceHabit\AbstinenceHabitData;
use App\Data\CountHabit\CountHabitData;
use App\Data\DailyHabit\DailyHabitData;
use App\Enums\HabitColor;
use App\Enums\HabitIcon;
use App\Enums\HabitType;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Count\CountHabit;
use App\Models\Daily\DailyHabit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use LogicException;

/**
 * @property string $id
 * @property string $title
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $starts_at
 * @property \Carbon\CarbonImmutable|null $ends_at
 * @property \Carbon\CarbonImmutable|null $started_at
 * @property \Carbon\CarbonImmutable|null $ended_at
 * @property string $habitable_type
 * @property string $habitable_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property bool $is_public
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property HabitColor|null $color
 * @property HabitIcon|null $icon
 * @property-read Model $habitable
 * @property-read User|null $leader
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HabitNote> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HabitParticipant> $participants
 * @property-read int|null $participants_count
 * @property-read HabitParticipant|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\HabitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereHabitableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereHabitableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit withoutTrashed()
 *
 * @mixin \Eloquent
 */
final class Habit extends Model
{
    /** @use HasFactory<\Database\Factories\HabitFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * @return MorphTo<Model, $this>
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
            secondKey: 'id',
            secondLocalKey: 'user_id'
        )->where('habit_participant.is_leader', true);
    }

    /**
     * @return HasMany<HabitParticipant, $this>
     */
    public function participants(): HasMany
    {
        return $this->hasMany(HabitParticipant::class);
    }

    /**
     * @return BelongsToMany<User, $this, HabitParticipant>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'habit_participant')->using(HabitParticipant::class);
    }

    /**
     * @return HasMany<HabitNote, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(HabitNote::class)->latest();
    }

    public function getHabitableResource(): null|AbstinenceHabitData|CountHabitData|DailyHabitData
    {
        if ($this->habitable::class === CountHabit::class) {
            assert($this->habitable instanceof CountHabit);

            return CountHabitData::from($this->habitable);
        }
        if ($this->habitable::class === AbstinenceHabit::class) {
            assert($this->habitable instanceof AbstinenceHabit);

            return AbstinenceHabitData::from($this->habitable);
        }
        if ($this->habitable::class === DailyHabit::class) {
            assert($this->habitable instanceof DailyHabit);

            return DailyHabitData::from($this->habitable);
        }

        return null;
    }

    public function getType(): HabitType
    {
        return match (true) {
            $this->habitable instanceof AbstinenceHabit => HabitType::Abstinence,
            $this->habitable instanceof CountHabit => HabitType::Count,
            $this->habitable instanceof DailyHabit => HabitType::Daily,
            default => throw new LogicException('Unknown habitable type: '.$this->habitable),
        };
    }

    protected function casts(): array
    {
        return [
            'name' => app()->environment('production') ? 'encrypted' : 'string',
            'started_at' => 'immutable_datetime',
            'ended_at' => 'immutable_datetime',
            'starts_at' => 'immutable_datetime',
            'ends_at' => 'immutable_datetime',
            'deleted_at' => 'immutable_datetime',
            'is_public' => 'boolean',
            'color' => HabitColor::class,
            'icon' => HabitIcon::class,
        ];
    }
}
