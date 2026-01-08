<?php

declare(strict_types=1);

namespace Database\Factories\Count;

use App\Enums\MeasurementUnitTypeEnum;
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
            'measurement_unit_type' => fake()->randomElement(MeasurementUnitTypeEnum::class),
        ];
    }
}
