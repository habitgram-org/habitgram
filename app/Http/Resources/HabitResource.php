<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Habit $resource
 */
final class HabitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->whenNotNull($this->resource->description),
            'habitable' => $this->resource->getHabitableResource(),
            'type' => $this->resource->getType(),
            'starts_at' => $this->whenNotNull($this->resource->starts_at),
            'ends_at' => $this->whenNotNull($this->resource->ends_at),
            'started_at' => $this->whenNotNull($this->resource->started_at?->toDayDateTimeString()),
            'ended_at' => $this->whenNotNull($this->resource->ended_at),
            'has_started' => $this->resource->starts_at < now() || ! is_null($this->resource->started_at),
        ];
    }
}
