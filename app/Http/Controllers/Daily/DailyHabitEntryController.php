<?php

declare(strict_types=1);

namespace App\Http\Controllers\Daily;

use Illuminate\Http\RedirectResponse;

final class DailyHabitEntryController
{
    public function store(): RedirectResponse
    {
        return back();
    }

    public function destroy(): RedirectResponse
    {
        return back();
    }
}
