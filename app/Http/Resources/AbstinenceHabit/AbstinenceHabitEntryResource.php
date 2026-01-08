<?php

declare(strict_types=1);

namespace App\Http\Resources\AbstinenceHabit;

use App\Http\Resources\HabitEntryNoteResource;
use App\Models\Abstinence\AbstinenceHabitEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property AbstinenceHabitEntry $resource
 */
final class AbstinenceHabitEntryResource extends JsonResource
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
            'happened_at' => $this->resource->happened_at,
            'notes' => HabitEntryNoteResource::collection($this->whenLoaded('notes')),
            'created_at' => $this->whenNotNull($this->resource->created_at),
        ];
    }
}
