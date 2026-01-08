<?php

declare(strict_types=1);

namespace App\Http\Controllers\Habit;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Count\CountHabit;
use App\Models\Habit;
use Illuminate\Contracts\Auth\Access\Gate;

final readonly class HabitController
{
    public function __construct(private Gate $gate) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->gate->authorize('index', Habit::class);

        $user = auth()->user();

        return inertia('habits/index', [
            'habits' => HabitResource::collection($user->habits),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHabitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Habit $habit)
    {
        $this->gate->authorize('view', $habit);

        $habit->load('habitable.entries.notes')
            ->loadMorphSum('habitable', [
                CountHabit::class => ['entries'],
            ], 'value');

        return inertia('habits/show', [
            'habit' => new HabitResource($habit),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habit $habit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHabitRequest $request, Habit $habit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habit $habit)
    {
        //
    }
}
