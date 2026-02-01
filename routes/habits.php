<?php

declare(strict_types=1);

use App\Http\Controllers\Habit\Count\CountHabitController;
use App\Http\Controllers\Habit\Count\CountHabitEntryController;
use App\Http\Controllers\Habit\HabitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->as('habits.')->prefix('/habits')->group(function (): void {
    Route::get('', [HabitController::class, 'index'])->name('index');
    Route::get('{habit}', [HabitController::class, 'show'])->name('show');
    Route::delete('{habit}', [HabitController::class, 'destroy'])->name('destroy');

    /* Count Habit */
    Route::as('count.')->prefix('/count')->group(function (): void {
        Route::post('', [CountHabitController::class, 'store'])->name('store');
        Route::patch('{countHabit}', [CountHabitController::class, 'update'])->name('update');

        /* Count Habit Entry */
        Route::as('entries.')->prefix('{countHabit}/entries')->group(function (): void {
            Route::post('', [CountHabitEntryController::class, 'store'])->name('store');
            Route::patch('{countHabitEntry}', [CountHabitEntryController::class, 'update'])->name('update');
            Route::delete('{countHabitEntry}', [CountHabitEntryController::class, 'destroy'])->name('destroy');
        });
    });
});
