<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Models\Habit;
use Illuminate\Database\Eloquent\Builder;

final readonly class SearchFilter
{
    public function __construct(
        private ?string $search,
    ) {}

    /**
     * @param Builder<Habit> $query
     */
    public function __invoke(Builder $query): void
    {
        $query->when($this->search, function (Builder $query): void {
            $query->whereLike('name', '%'.$this->search.'%');
        });
    }
}
