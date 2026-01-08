<?php

declare(strict_types=1);

use App\Models\Habit;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
    $habit = Habit::find('019b98ab-e53e-70b6-921a-afc4a6228492');
    $habit->load('habitable.entries.notes');
    dd($habit->habitable->entries);
})->purpose('Display an inspiring quote');
