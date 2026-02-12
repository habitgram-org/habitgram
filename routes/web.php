<?php

declare(strict_types=1);

use App\Http\Controllers\MainController;

require __DIR__.'/auth.php';
require __DIR__.'/habits.php';

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/', [MainController::class, 'index'])->name('index');
});
