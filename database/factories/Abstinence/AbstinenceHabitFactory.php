<?php

declare(strict_types=1);

namespace Database\Factories\Abstinence;

use App\Enums\UnitType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Abstinence\AbstinenceHabit>
 */
final class AbstinenceHabitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hasGoal = fake()->boolean();

        return [
            'goal' => $hasGoal ? fake()->numberBetween(10_000, 100_000) : null,
            'goal_unit' => $hasGoal ? fake()->randomElement(UnitType::time()) : null,
        ];
    }
}
