<?php

declare(strict_types=1);

namespace App\Http\Resources\AbstinenceHabit;

use App\Models\Abstinence\AbstinenceHabit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property AbstinenceHabit $resource
 */
final class AbstinenceHabitResource extends JsonResource
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
            'entries' => AbstinenceHabitEntryResource::collection($this->whenLoaded('entries')),
            'created_at' => $this->whenNotNull($this->resource->created_at),
        ];
    }
}
