<?php

declare(strict_types=1);

namespace App\Http\Resources\CountHabit;

use App\Http\Resources\HabitEntryNoteResource;
use App\Models\Count\CountHabitEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property CountHabitEntry $resource
 */
final class CountHabitEntryResource extends JsonResource
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
            'value' => $this->resource->value,
            'notes' => HabitEntryNoteResource::collection($this->whenLoaded('entries')),
            'created_at' => $this->whenNotNull($this->resource->created_at?->toDayDateTimeString()),
        ];
    }
}
