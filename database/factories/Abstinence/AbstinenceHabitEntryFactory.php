<?php

declare(strict_types=1);

namespace Database\Factories\Abstinence;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Abstinence\AbstinenceHabitEntry>
 */
final class AbstinenceHabitEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'happened_at' => fake()->dateTimeBetween(now()->subYear()),
        ];
    }
}
