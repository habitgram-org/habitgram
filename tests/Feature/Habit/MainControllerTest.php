<?php

declare(strict_types=1);

use App\Models\User;

test('user cannot access habits list page without authentication', function (): void {
    $response = $this->get('/');

    $response->assertStatus(302)
        ->assertRedirect('/login');
});

test('user can access habits list page after authentication', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/');

    $response->assertStatus(200);
});
