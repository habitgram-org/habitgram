<?php

declare(strict_types=1);

namespace App\Http\Resources\DailyHabit;

use App\Models\Daily\DailyHabitEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property DailyHabitEntry $resource
 */
final class DailyHabitEntryResource extends JsonResource
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
            'failed_at' => $this->whenNotNull($this->resource->failed_at),
            'succeeded_at' => $this->whenNotNull($this->resource->succeeded_at),
            'created_at' => $this->resource->created_at,
        ];
    }
}
