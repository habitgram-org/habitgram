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
        Schema::table('habit_entry_notes', function (Blueprint $table) {
            $table->renameColumn('habit_entryable_type', 'notable_type');
            $table->renameColumn('habit_entryable_id', 'notable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habit_entry_notes', function (Blueprint $table) {
            $table->renameColumn('notable_type', 'habit_entryable_type');
            $table->renameColumn('notable_id', 'habit_entryable_id');
        });
    }
};
