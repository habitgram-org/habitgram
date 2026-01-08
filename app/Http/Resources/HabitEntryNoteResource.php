<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\HabitEntryNote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property HabitEntryNote $resource
 */
final class HabitEntryNoteResource extends JsonResource
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
            'content' => $this->resource->content,
            'created_at' => $this->whenNotNull($this->resource->created_at),
        ];
    }
}
