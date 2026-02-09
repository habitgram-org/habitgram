<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Enums\HabitType;
use Illuminate\Database\Eloquent\Builder;

final readonly class TypeFilter
{
    public function __construct(
        private ?HabitType $type,
    ) {}

    public function __invoke(Builder $query): void
    {
        $query->when($this->type, function (Builder $query): void {
            $query->where('habitable_type', $this->type->getModel());
        });
    }
}
