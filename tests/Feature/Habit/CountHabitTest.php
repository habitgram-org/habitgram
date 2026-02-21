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

test('user cannot create a count habit without proper unit type', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/habits', [
        'title' => 'Daily Push-ups',
        'type' => HabitType::Count->value,
        'color' => HabitColor::Blue->value,
        'icon' => HabitIcon::Dumbbell->value,
        'is_public' => 'on',
        'count.unit_type' => 'invalid unit',
        'count.target' => 50,
    ]);

    $response->assertSessionHasErrors(['count.unit_type']);
});

test('user can create a count habit with valid unit type', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/habits', [
        'title' => 'Daily Push-ups',
        'type' => HabitType::Count->value,
        'color' => HabitColor::Blue->value,
        'icon' => HabitIcon::Dumbbell->value,
        'is_public' => 'on',
        'count.unit_type' => UnitType::PushUps->value,
        'count.target' => 50,
    ]);

    $habit = Habit::latest()->first();

    $response->assertRedirectToRoute('habits.show', ['habit' => $habit]);

    $this->assertDatabaseCount('habits', 1);
    $this->assertDatabaseCount('count_habits', 1);
    $this->assertDatabaseHas('count_habits', ['goal' => 50, 'unit' => UnitType::PushUps->value]);
    $this->assertDatabaseHas('habit_participant', [
        'user_id' => $user->id,
        'habit_id' => $habit->id,
    ]);
});

test('user can create a count habit without goal', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/habits', [
        'title' => 'Track Water',
        'type' => HabitType::Count->value,
        'color' => HabitColor::Cyan->value,
        'icon' => HabitIcon::Droplets->value,
        'is_public' => 'on',
        'count.unit_type' => UnitType::Glasses->value,
    ]);

    $habit = Habit::latest()->first();

    $response->assertRedirectToRoute('habits.show', ['habit' => $habit]);

    $this->assertDatabaseCount('habits', 1);
    $this->assertDatabaseCount('count_habits', 1);
    $this->assertDatabaseHas('count_habits', ['goal' => null, 'unit' => UnitType::Glasses->value]);
    $this->assertDatabaseHas('habit_participant', [
        'user_id' => $user->id,
        'habit_id' => $habit->id,
    ]);
});

test('user cannot create a count habit without unit type', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/habits', [
        'title' => 'Daily Steps',
        'type' => HabitType::Count->value,
        'color' => HabitColor::Emerald->value,
        'icon' => HabitIcon::Target->value,
        'is_public' => 'on',
        'count.target' => 10000,
    ]);

    $response->assertSessionHasErrors(['count.unit_type']);
});
