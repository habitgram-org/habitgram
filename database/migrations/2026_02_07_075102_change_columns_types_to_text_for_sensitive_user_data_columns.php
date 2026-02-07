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
        Schema::table('habits', function (Blueprint $table) {
            $table->text('name')->change();
        });

        Schema::table('habit_notes', function (Blueprint $table) {
            $table->text('note')->change();
        });

        Schema::table('daily_habit_entries', function (Blueprint $table) {
            $table->text('note')->nullable()->change();
        });

        Schema::table('count_habit_entries', function (Blueprint $table) {
            $table->text('note')->nullable()->change();
        });

        Schema::table('abstinence_habit_relapses', function (Blueprint $table) {
            $table->text('reason')->change();
        });
    }
};
