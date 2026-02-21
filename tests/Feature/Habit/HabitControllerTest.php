<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

pest()->use(RefreshDatabase::class);

test('user can access habit creation page', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/habits/create')
        ->assertInertia(fn (AssertableInertia $page) => $page->component('habits/create'));

    $response->assertStatus(200);
});

test('user cannot create a habit with empty fields', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/habits');

    $response->assertSessionHasErrors(['title', 'color', 'icon', 'type', 'is_public']);
});
