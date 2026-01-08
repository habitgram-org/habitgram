<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::update(
            'UPDATE habits SET started_at = now(), starts_at = null WHERE true'
        );
    }
};
