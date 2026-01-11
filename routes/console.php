<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
    dd(App\Models\Count\CountHabitEntry::find('019ba1d0-dc47-72f5-ae82-c600ae71e748')->user);
})->purpose('Display an inspiring quote');
