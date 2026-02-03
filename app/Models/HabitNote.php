<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $id
 * @property string $note
 * @property string $habitable_type
 * @property string $habitable_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read Model $habitable
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereHabitableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereHabitableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitNote whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class HabitNote extends Model
{
    /** @use HasFactory<\Database\Factories\HabitNoteFactory> */
    use HasUuids, HasFactory;

    /**
     * @return MorphTo<Model, $this>
     */
    public function habitable(): MorphTo
    {
        return $this->morphTo('habitable');
    }
}
