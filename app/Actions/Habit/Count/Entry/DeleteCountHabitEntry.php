<?php

declare(strict_types=1);

namespace App\Actions\Habit\Count\Entry;

use App\Models\Count\CountHabitEntry;
use Illuminate\Support\Facades\DB;

final class DeleteCountHabitEntry
{
    public function run(CountHabitEntry $entry): void
    {
        DB::transaction(function () use ($entry): void {
            $entry->delete();
        });
    }
}
