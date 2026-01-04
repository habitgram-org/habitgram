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
        Schema::create('daily_habit_entries', function (Blueprint $table) {
            $table->uuid('id')->unique();

            $table->timestamp('failed_at')->nullable();
            $table->timestamp('succeed_at')->nullable();

            $table->foreignUuid('daily_habit_id')
                ->constrained('daily_habits')
                ->cascadeOnDelete();

            $table->foreignUuid('habit_participant_id')
                ->constrained('habit_participant')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        // Add CHECK constraint using raw SQL
        DB::statement(<<<'EOF'
            ALTER TABLE daily_habit_entries
            ADD CONSTRAINT only_one_state_at_a_time_check
            CHECK (
                (failed_at IS NOT NULL AND succeed_at IS NULL) OR
                (failed_at IS NULL AND succeed_at IS NOT NULL)
            )
        EOF);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_habit_entries');
    }
};
