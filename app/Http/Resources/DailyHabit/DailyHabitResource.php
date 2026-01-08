<?php

declare(strict_types=1);

namespace App\Http\Resources\DailyHabit;

use App\Models\Daily\DailyHabit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property DailyHabit $resource
 */
final class DailyHabitResource extends JsonResource
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
            'entries' => DailyHabitEntryResource::collection($this->whenLoaded('entries')),
            'created_at' => $this->whenNotNull($this->resource->created_at),
        ];
    }
}
