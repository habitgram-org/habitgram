<?php

declare(strict_types=1);

namespace App\Http\Controllers\Habit\Count;

use App\Actions\Habit\Count\Entry\CreateCountHabitEntry;
use App\Actions\Habit\Count\Entry\DeleteCountHabitEntry;
use App\Http\Requests\Habit\Count\Entry\StoreCountHabitEntryRequest;
use App\Models\Count\CountHabit;
use App\Models\Count\CountHabitEntry;
use App\Models\Habit;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final readonly class CountHabitEntryController
{
    public function __construct(
        private Gate $gate
    ) {}

    public function store(
        CountHabit $countHabit,
        StoreCountHabitEntryRequest $request,
        CreateCountHabitEntry $createCountHabitEntry
    ): RedirectResponse {
        $this->gate->authorize('is-participant', [Habit::class, $countHabit->habit]);

        $dto = $request->getDTO();

        $createCountHabitEntry->run($countHabit, Auth::user(), $dto);

        Inertia::flash('newly_added_amount', $dto->amount);

        return back();
    }

    public function destroy(
        CountHabitEntry $countHabitEntry,
        DeleteCountHabitEntry $deleteCountHabitEntry
    ): RedirectResponse {
        $this->gate->authorize('is-participant', [Habit::class, $countHabitEntry->countHabit->habit]);

        $deleteCountHabitEntry->run($countHabitEntry);

        return back();
    }
}
