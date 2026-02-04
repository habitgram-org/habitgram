<?php

declare(strict_types=1);

namespace App\Http\Controllers\Abstinence;

use App\Actions\Habit\Abstinence\Relapse\CreateAbstinenceHabitRelapse;
use App\Http\Requests\Habit\Abstinence\Relapse\StoreAbstinenceHabitRelapseRequest;
use App\Models\Abstinence\AbstinenceHabit;
use Illuminate\Http\RedirectResponse;

final class AbstinenceHabitRelapseController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        AbstinenceHabit $abstinenceHabit,
        StoreAbstinenceHabitRelapseRequest $request,
        CreateAbstinenceHabitRelapse $createAbstinenceHabitRelapse
    ): RedirectResponse {
        $createAbstinenceHabitRelapse->run(
            dto: $request->getDTO(),
            abstinenceHabit: $abstinenceHabit,
            participant: auth()->user()->participantFor($abstinenceHabit)
        );

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        return back();
    }
}
