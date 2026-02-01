<?php

declare(strict_types=1);

namespace Database\Factories\Count;

use App\Enums\UnitType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Count\CountHabit>
 */
final class CountHabitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit' => fake()->randomElement(UnitType::class),
            'goal' => fake()->optional()->numberBetween(100_000, 1_000_000),
        ];
    }
}
