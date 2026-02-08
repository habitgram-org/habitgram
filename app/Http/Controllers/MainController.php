<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\HabitData;
use Spatie\LaravelData\PaginatedDataCollection;

final class MainController
{
    public function index()
    {
        if (auth()->check()) {
            if (! auth()->user()?->hasVerifiedEmail()) {
                return inertia('auth/verify-email');
            }

            $habits = auth()->user()
                ->habits()
                ->select(['habits.id', 'habits.name', 'habitable_type', 'habitable_id'])
                ->with(['habitable'])
                ->paginate(perPage: 8);

            return inertia('habits/index', [
                'response' => HabitData::collect(
                    items: $habits,
                    into: PaginatedDataCollection::class,
                )->include('image'),
            ]);
        }

        return inertia('auth/login');
    }
}
