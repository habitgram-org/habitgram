<?php

declare(strict_types=1);

use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('index');

require __DIR__.'/auth.php';
