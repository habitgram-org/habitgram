<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(<<<'EOF'
            ALTER TABLE habits
            ADD CONSTRAINT starts_at_or_started_at_one_of_them_should_be_present_check
            CHECK(
                (starts_at IS NULL AND started_at IS NOT NULL) OR
                (starts_at IS NOT NULL AND started_at IS NULL)
            )
EOF);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(<<<'EOF'
            ALTER TABLE habits DROP CONSTRAINT starts_at_or_started_at_one_of_them_should_be_present_check
EOF);
    }
};
