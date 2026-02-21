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
        DB::statement(<<<'EOF'
            ALTER TABLE habits
            DROP CONSTRAINT starts_at_or_started_at_one_of_them_should_be_present_check
EOF);

        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['starts_at', 'ends_at', 'started_at', 'ended_at']);
        });
    }
};
