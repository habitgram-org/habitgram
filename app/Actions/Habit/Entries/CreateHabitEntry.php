<?php

declare(strict_types=1);

namespace App\Actions\Habit\Entries;

use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateHabitEntry
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @throws Throwable
     */
    public function run(): void
    {
        DB::transaction(function (): void {});
    }
}
