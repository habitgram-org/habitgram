<?php

declare(strict_types=1);

namespace App\Http\Controllers\Habit;

use App\Actions\Habit\DeleteHabit;
use App\Http\Resources\HabitResource;
use App\Models\Count\CountHabit;
use App\Models\Habit;
use Illuminate\Contracts\Auth\Access\Gate;
use Inertia\Response;
use Throwable;

final readonly class HabitController
{
    public function __construct(private Gate $gate) {}

    public function index(): Response
    {
        $this->gate->authorize('viewAny', Habit::class);

        $habits = auth()->user()
            ->habits()
            ->select(['habits.id', 'habits.name', 'habits.description'])
            ->get();

        return inertia('habits/index', [
            'habits' => HabitResource::collect($habits),
        ]);
    }

    public function show(Habit $habit): Response
    {
        $this->gate->authorize('view', $habit);

        $habit->load(['habitable.entries', 'users'])
            ->loadMorphSum('habitable', [
                CountHabit::class => ['entries'],
            ], 'amount')
            ->loadMorphAvg('habitable', [
                CountHabit::class => ['entries'],
            ], 'amount');

        //        dd(HabitResource::fromModel($habit));

        return inertia('habits/show', [
            'habit' => HabitResource::fromModel($habit),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(Habit $habit, DeleteHabit $deleteHabit): Response
    {
        $this->gate->authorize('delete', $habit);

        $deleteHabit->run($habit);

        return inertia('habits/index');
    }
}
