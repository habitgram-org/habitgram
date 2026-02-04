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
        Schema::table('habit_notes', function (Blueprint $table) {
            $table->dropMorphs('habitable');

            $table->foreignUuid('habit_id')
                ->constrained('habits')
                ->cascadeOnDelete();

            $table->foreignUuid('habit_participant_id')
                ->constrained('habit_participant')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habit_notes', function (Blueprint $table) {
            $table->uuidMorphs('habitable');

            $table->dropForeign(['habit_participant_id']);
            $table->dropColumn('habit_participant_id');
        });
    }
};
