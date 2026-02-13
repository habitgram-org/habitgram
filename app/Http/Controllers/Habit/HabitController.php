<?php

declare(strict_types=1);

namespace App\Http\Controllers\Habit;

use App\Actions\Habit\CreateHabit;
use App\Actions\Habit\DeleteHabit;
use App\Data\HabitData;
use App\Enums\HabitColor;
use App\Enums\HabitIcon;
use App\Enums\UnitType;
use App\Http\Requests\Habit\StoreHabitRequest;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Count\CountHabit;
use App\Models\Daily\DailyHabit;
use App\Models\Habit;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

final readonly class HabitController
{
    public function __construct(private Gate $gate) {}

    public function create(): Response
    {
        $this->gate->authorize('create', Habit::class);

        return inertia('habits/create', [
            'colors' => HabitColor::toArray(),
            'icons' => HabitIcon::cases(),
            'countUnitTypes' => UnitType::toArray(),
            'abstinenceUnitTypes' => [
                ['name' => UnitType::Seconds->name, 'value' => UnitType::Seconds->value],
                ['name' => UnitType::Minutes->name, 'value' => UnitType::Minutes->value],
                ['name' => UnitType::Hours->name, 'value' => UnitType::Hours->value],
            ],
        ]);
    }

    public function store(StoreHabitRequest $request, CreateHabit $createHabit): RedirectResponse
    {
        $this->gate->authorize('create', Habit::class);

        $habit = $createHabit->run($request->getDTO());

        return to_route('habits.show', ['habit' => $habit]);
    }

    public function show(Habit $habit, Request $request): Response
    {
        $this->gate->authorize('view', $habit);

        $habit->load([
            'habitable.entries' => function (HasMany $query) use ($request): void {
                if ($query->getParent() instanceof DailyHabit) {
                    $query->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [
                        $request->get('year') ?? now()->year,
                    ])->latest();
                }
            },
            'users',
            'notes',
        ])
            ->loadMorphSum('habitable', [
                CountHabit::class => ['entries'],
            ], 'amount')
            ->loadMorphCount('habitable', [
                AbstinenceHabit::class => ['relapses'],
            ])
            ->loadCount('notes');

        return inertia('habits/show', [
            'habit' => HabitData::from($habit)
                ->include('description', 'notes', 'notes_count', 'habitable.*'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(Habit $habit, DeleteHabit $deleteHabit): RedirectResponse
    {
        $this->gate->authorize('delete', $habit);

        $deleteHabit->run($habit);

        return to_route('index');
    }
}
