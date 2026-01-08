<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('daily_habit_entries', function (Blueprint $table) {
            $table->renameColumn('succeed_at', 'succeeded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_habit_entries', function (Blueprint $table) {
            $table->renameColumn('succeeded_at', 'succeed_at');
        });
    }
};
