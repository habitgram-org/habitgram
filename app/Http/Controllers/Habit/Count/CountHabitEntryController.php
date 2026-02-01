<?php

declare(strict_types=1);

namespace App\Http\Controllers\Habit\Count;

use App\Actions\Habit\Count\Entry\CreateCountHabitEntry;
use App\Actions\Habit\Count\Entry\DeleteCountHabitEntry;
use App\Http\Requests\Habit\Count\Entry\StoreCountHabitEntryRequest;
use App\Models\Count\CountHabit;
use App\Models\Count\CountHabitEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final class CountHabitEntryController
{
    public function __construct() {}

    public function store(
        CountHabit $countHabit,
        StoreCountHabitEntryRequest $request,
        CreateCountHabitEntry $createCountHabitEntry
    ): RedirectResponse {
        // TODO: Authorize
        $dto = $request->getDTO();

        $createCountHabitEntry->run($countHabit, Auth::user(), $dto);

        Inertia::flash('newly_added_amount', $dto->amount);

        return back();
    }

    public function destroy(
        CountHabitEntry $countHabitEntry,
        DeleteCountHabitEntry $deleteCountHabitEntry
    ): RedirectResponse {
        // TODO: Authorize

        $deleteCountHabitEntry->run($countHabitEntry);

        return back();
    }
}
