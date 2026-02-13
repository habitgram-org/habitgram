<?php

declare(strict_types=1);

use App\Http\Controllers\Abstinence\AbstinenceHabitController;
use App\Http\Controllers\Abstinence\AbstinenceHabitRelapseController;
use App\Http\Controllers\Daily\DailyHabitController;
use App\Http\Controllers\Daily\DailyHabitEntryController;
use App\Http\Controllers\Habit\Count\CountHabitController;
use App\Http\Controllers\Habit\Count\CountHabitEntryController;
use App\Http\Controllers\Habit\HabitController;
use App\Http\Controllers\Habit\HabitNoteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->as('habits.')->prefix('/habits')->group(function (): void {
    Route::get('create', [HabitController::class, 'create'])->name('create');
    Route::post('', [HabitController::class, 'store'])->name('store');
    Route::get('{habit}', [HabitController::class, 'show'])->name('show');
    Route::delete('{habit}', [HabitController::class, 'destroy'])->name('destroy');

    Route::as('notes.')->prefix('{habit}')->group(function (): void {
        Route::post('notes', [HabitNoteController::class, 'store'])->name('store');
    });

    /** Count Habit */
    Route::as('count.')->prefix('/count')->group(function (): void {
        Route::post('', [CountHabitController::class, 'store'])->name('store');
        Route::patch('{countHabit}', [CountHabitController::class, 'update'])->name('update');

        /* Count Habit Entry */
        Route::as('entries.')->prefix('{countHabit}/entries')->group(function (): void {
            Route::post('', [CountHabitEntryController::class, 'store'])->name('store');
            Route::delete('{countHabitEntry}', [CountHabitEntryController::class, 'destroy'])->name('destroy');
        });
    });

    /** Abstinence Habit  */
    Route::as('abstinence.')->prefix('/abstinence')->group(function (): void {
        Route::post('', [AbstinenceHabitController::class, 'store'])->name('store');
        Route::patch('{abstinenceHabit}', [AbstinenceHabitController::class, 'update'])->name('update');

        /* Abstinence Habit Relapse */
        Route::as('relapses.')->prefix('{abstinenceHabit}/relapses')->group(function (): void {
            Route::post('', [AbstinenceHabitRelapseController::class, 'store'])->name('store');
            Route::delete('{abstinenceHabitRelapse}', [AbstinenceHabitRelapseController::class, 'destroy'])->name('destroy');
        });
    });

    /** Daily Habit */
    Route::as('daily.')->prefix('/daily')->group(function (): void {
        Route::post('', [DailyHabitController::class, 'store'])->name('store');
        Route::patch('{dailyHabit}', [DailyHabitController::class, 'update'])->name('update');

        /* Daily Habit Entry */
        Route::as('entries.')->prefix('{dailyHabit}/entries')->group(function (): void {
            Route::post('', [DailyHabitEntryController::class, 'store'])->name('store');
            Route::delete('{dailyHabitEntry}', [DailyHabitEntryController::class, 'destroy'])->name('destroy');
        });
    });
});
