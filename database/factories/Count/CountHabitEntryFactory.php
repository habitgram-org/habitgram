<?php

declare(strict_types=1);

namespace Database\Factories\Count;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Count\CountHabitEntry>
 */
final class CountHabitEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(1, 1_000),
            'note' => fake()->optional(0.25)->realText(),
        ];
    }
}
