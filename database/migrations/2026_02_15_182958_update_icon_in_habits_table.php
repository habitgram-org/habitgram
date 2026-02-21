<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var string[] */
    private const array CURRENT_ICONS = [
        'Apple',
        'GraduationCap',
        'PiggyBank',
        'ShowerHead',
        'Pi',
        'CakeSlice',
        'Target',
        'BookOpen',
        'Dumbbell',
        'Droplets',
        'Moon',
        'Sun',
        'Briefcase',
        'Code',
        'Music',
        'Palette',
        'Brain',
        'Utensils',
        'BrainCircuit',
        'DollarSign',
        'Heart',
        'Smile',
        'Coffee',
        'Gamepad2',
        'ShoppingCart',
        'Smartphone',
        'Banana',
        'Ban',
        'CigaretteOff',
        'WineOff',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->enum('tmp_icon', self::CURRENT_ICONS)->nullable();
        });

        DB::statement('UPDATE habits SET tmp_icon = icon');

        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn('icon');
        });

        Schema::table('habits', function (Blueprint $table) {
            $table->renameColumn('tmp_icon', 'icon');
        });
    }
};
