<?php

declare(strict_types=1);

namespace App\Http\Controllers\Habit;

use App\Enums\HabitType;
use App\Models\Count\CountHabitEntry;
use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class HabitEntryController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Habit $habit, Request $request)
    {
        // TODO: Policy goes here

        // TODO: refactor this mess

        $request->validate([
            'type' => ['required', Rule::enum(HabitType::class)],
            'value' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);

        $participantId = $habit->participants()
            ->where('user_id', auth()->id())
            ->value('habit_participant.id');

        $entry = new CountHabitEntry();
        $entry->value = $request->get('value');
        $entry->habit_participant_id = $participantId;

        $habit->habitable->entries()->save($entry);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
