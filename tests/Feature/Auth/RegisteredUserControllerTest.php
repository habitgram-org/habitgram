<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Inertia\Testing\AssertableInertia;

pest()->use(RefreshDatabase::class);

test('user can access registration page', function (): void {
    $response = $this->get('/signup');

    $response->assertStatus(200)
        ->assertInertia(function (AssertableInertia $page): void {
            $page->component('auth/signup');
        });
});

test('user cannot register with short username', function (): void {
    $response = $this->post('/signup', [
        'username' => '@john',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors(['username']);
});

test('user cannot register with simple password', function (): void {
    $response = $this->post('/signup', [
        'username' => '@john1',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('user can register with valid data', function (): void {
    Event::fake();

    $response = $this->post('/signup', [
        'username' => '@john1',
        'email' => 'john@example.com',
        'password' => 'StrongPassword!123$',
        'password_confirmation' => 'StrongPassword!123$',
    ]);
    $response->assertStatus(302)
        ->assertRedirect('/')
        ->assertSessionHasNoErrors();

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'email_verified_at' => null,
    ]);

    Event::assertDispatched(Registered::class);
});
