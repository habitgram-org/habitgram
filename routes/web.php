<?php

declare(strict_types=1);

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;

require __DIR__.'/auth.php';
require __DIR__.'/habits.php';

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/', [MainController::class, 'index'])->name('index');

    Route::inertia('/activity', 'activity')->name('activity');

    Route::controller(ProfileController::class)->group(function (): void {
        Route::get('{username}', 'show')->name('profile');
    });
});
