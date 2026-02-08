<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\HabitColor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habit>
 */
final class HabitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, asText: true),
            'description' => fake()->optional()->text(),
            'starts_at' => null,
            'ends_at' => null,
            'started_at' => fake()->dateTimeBetween(now()->subYear()),
            'ended_at' => null,
            'is_public' => fake()->boolean(),
            'color' => fake()->randomElement(HabitColor::class),
        ];
    }
}
