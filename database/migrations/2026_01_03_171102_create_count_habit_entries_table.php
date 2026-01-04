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
        Schema::create('count_habit_entries', function (Blueprint $table) {
            $table->uuid('id')->unique();

            $table->unsignedInteger('value');

            $table->foreignUuid('count_habit_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignUuid('habit_participant_id')
                ->constrained('habit_participant')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('count_habit_entries');
    }
};
