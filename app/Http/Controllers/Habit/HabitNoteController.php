<?php

declare(strict_types=1);

namespace App\Http\Controllers\Habit;

use App\Actions\Habit\Abstinence\Note\CreateHabitNote;
use App\Http\Requests\Habit\Abstinence\Note\StoreHabitNoteRequest;
use App\Models\Habit;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final readonly class HabitNoteController
{
    public function __construct(private Gate $gate) {}

    public function store(
        Habit $habit,
        StoreHabitNoteRequest $request,
        CreateHabitNote $createHabitNote
    ): RedirectResponse {
        $this->gate->authorize('is-participant', [Habit::class, $habit->habit]);

        $createHabitNote->run($habit, Auth::user(), $request->getDTO());

        return back();
    }
}
