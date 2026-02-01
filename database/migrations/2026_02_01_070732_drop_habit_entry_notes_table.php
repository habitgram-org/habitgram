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
        Schema::dropIfExists('habit_entry_notes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('habit_entry_notes', function (Blueprint $table) {
            $table->uuid('id')->unique();

            $table->text('content');

            $table->uuidMorphs('habit_entryable');

            $table->foreignUuid('habit_participant_id')
                ->constrained('habit_participant')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }
};
