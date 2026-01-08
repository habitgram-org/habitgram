<?php

declare(strict_types=1);

namespace App\Http\Resources\CountHabit;

use App\Models\Count\CountHabit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property CountHabit $resource
 */
final class CountHabitResource extends JsonResource
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
            'total' => $this->resource->entries_sum_value,
            'measurement_type_unit' => $this->resource->measurement_unit_type->name,
            'entries' => CountHabitEntryResource::collection($this->whenLoaded('entries')),
            'created_at' => $this->whenNotNull($this->resource->created_at?->toDateString()),
        ];
    }
}
