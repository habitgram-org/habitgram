<?php

declare(strict_types=1);

use App\Enums\HabitColor;
use App\Enums\HabitIcon;
use App\Enums\HabitType;
use App\Enums\UnitType;
use App\Models\Habit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

test('user cannot create an abstinence habit without proper goal unit', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/habits', [
        'title' => 'No Smoking',
        'type' => HabitType::Abstinence->value,
        'color' => HabitColor::Rose->value,
        'icon' => HabitIcon::CigaretteOff->value,
        'is_public' => 'on',
        'abstinence.goal_unit' => -1,
        'abstinence.goal' => 0,
    ]);

    $response->assertSessionHasErrors(['abstinence.goal_unit']);
});

test('user can create an abstinence habit with proper goal unit', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/habits', [
        'title' => 'No Smoking',
        'type' => HabitType::Abstinence->value,
        'color' => HabitColor::Rose->value,
        'icon' => HabitIcon::CigaretteOff->value,
        'is_public' => 'on',
        'abstinence.goal_unit' => UnitType::Hours->value,
        'abstinence.goal' => 1,
    ]);

    $habit = Habit::latest()->first();

    $response->assertRedirectToRoute('habits.show', ['habit' => $habit]);

    $this->assertDatabaseCount('habits', 1);
    $this->assertDatabaseCount('abstinence_habits', 1);
    $this->assertDatabaseHas('abstinence_habits', ['goal' => 1, 'goal_unit' => UnitType::Hours->value]);
    $this->assertDatabaseHas('habit_participant', [
        'user_id' => $user->id,
        'habit_id' => $habit->id,
    ]);
});
