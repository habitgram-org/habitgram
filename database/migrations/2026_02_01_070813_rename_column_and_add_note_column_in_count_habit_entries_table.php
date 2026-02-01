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
        Schema::table('count_habit_entries', function (Blueprint $table) {
            $table->renameColumn('value', 'amount');

            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('count_habit_entries', function (Blueprint $table) {
            $table->dropColumn('note');

            $table->renameColumn('amount', 'value');
        });
    }
};
