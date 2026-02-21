<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

pest()->use(RefreshDatabase::class);

test('user can access login page', function (): void {
    $response = $this->get('/login');

    $response->assertStatus(200)
        ->assertInertia(function (AssertableInertia $page): void {
            $page->component('auth/login');
        });
});

test('user can login with valid credentials', function (): void {
    User::factory()->create([
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(302)
        ->assertRedirect('/');

    $this->assertAuthenticated();
});

test('user cannot login with invalid credentials', function (): void {
    User::factory()->create([
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'john@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(302)
        ->assertRedirectBack()
        ->assertSessionHasErrors(['email']);

    $this->assertGuest();
});

test('user can logout', function (): void {
    $user = User::factory()->create([
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
    ]);
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertStatus(302)
        ->assertRedirectToRoute('index');

    $this->assertGuest();
});
