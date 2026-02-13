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
            $table->enum('color', [
                'bg-black',
                'bg-orange-500',
                'bg-slate-500',
                'bg-yellow-500',
                'bg-sky-500',
                'bg-emerald-500',
                'bg-teal-500',
                'bg-cyan-500',
                'bg-blue-500',
                'bg-indigo-500',
                'bg-violet-500',
                'bg-purple-500',
                'bg-pink-500',
                'bg-rose-500',
            ])->nullable();

            $table->enum('icon', [
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
                'Leaf',
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

            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['color', 'icon']);
        });
    }
};
