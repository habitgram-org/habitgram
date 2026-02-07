<?php

declare(strict_types=1);

namespace Database\Factories\Daily;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Daily\DailyHabitEntry>
 */
final class DailyHabitEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isSucceeded = fake()->boolean();
        $timestamp = fake()->dateTimeBetween(now()->subYear());

        return [
            'succeeded_at' => $isSucceeded ? $timestamp : null,
            'failed_at' => $isSucceeded ? null : $timestamp,
            'created_at' => $timestamp,
        ];
    }
}
