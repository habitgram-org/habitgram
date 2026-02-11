<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\HabitData;
use App\Enums\HabitType;
use App\Models\Scopes\SearchFilter;
use App\Models\Scopes\TypeFilter;
use Illuminate\Http\Request;
use Spatie\LaravelData\PaginatedDataCollection;

final class MainController
{
    public function index(Request $request)
    {
        $habits = auth()->user()
            ->habits()
            ->select(['habits.id', 'habits.name', 'habitable_type', 'habitable_id'])
            ->with(['habitable'])
            ->tap(new SearchFilter($request->query('search')))
            ->tap(new TypeFilter($request->enum('type', HabitType::class)))
            ->paginate(perPage: 8);

        return inertia('habits/index', [
            'response' => HabitData::collect(
                items: $habits,
                into: PaginatedDataCollection::class,
            )->include('image', 'habitable.goal', 'habitable.goal_unit'),
        ]);
    }
}
