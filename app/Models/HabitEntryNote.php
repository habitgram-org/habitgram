<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $content
 * @property string $habit_entryable_type
 * @property string $habit_entryable_id
 * @property string $habit_participant_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereHabitEntryableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereHabitEntryableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereHabitParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class HabitEntryNote extends Model
{
    use HasUuids;
}
