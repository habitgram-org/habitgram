<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\HabitParticipant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HabitNote>
 */
final class HabitNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'note' => fake()->realText(),
            'habit_participant_id' => HabitParticipant::factory(),
        ];
    }
}
