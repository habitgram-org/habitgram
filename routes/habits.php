<?php

declare(strict_types=1);

use App\Http\Controllers\Habit\HabitController;
use App\Http\Controllers\Habit\HabitEntryController;
use Illuminate\Support\Facades\Route;

Route::resource('habits', HabitController::class);
Route::apiResource('habits.entries', HabitEntryController::class);
