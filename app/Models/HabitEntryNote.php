<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Abstinence\AbstinenceHabitEntry;
use App\Models\Count\CountHabitEntry;
use App\Models\Daily\DailyHabitEntry;
use Database\Factories\HabitEntryNoteFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $id
 * @property string $content
 * @property string $notable_type
 * @property string $notable_id
 * @property string $habit_participant_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read AbstinenceHabitEntry|CountHabitEntry|DailyHabitEntry $notable
 *
 * @method static \Database\Factories\HabitEntryNoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereHabitParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereNotableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereNotableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitEntryNote whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class HabitEntryNote extends Model
{
    /** @use HasFactory<HabitEntryNoteFactory> */
    use HasFactory, HasUuids;

    /**
     * @return MorphTo<Model, $this>
     */
    public function notable(): MorphTo
    {
        return $this->morphTo('notable');
    }
}
