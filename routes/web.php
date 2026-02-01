<?php

declare(strict_types=1);

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;

Route::get('/', [MainController::class, 'index'])->name('index');

Route::controller(ProfileController::class)->group(function (): void {
    Route::get('{username}', 'show')->name('profile');
});

require __DIR__.'/auth.php';
require __DIR__.'/habits.php';
