<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_user_with_default_role()
    {
        $response = $this->post(route('register'), [
            'name' => 'Regular User',
            'email' => 'regular@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'regular@example.com',
            'role' => 'user',
        ]);
    }

    public function test_registration_with_valid_admin_invite_creates_admin()
    {
        // set invite token in environment for this test
        putenv('ADMIN_INVITE_TOKEN=admintoken123');

        $response = $this->post(route('register'), [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'invite_token' => 'admintoken123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_registration_with_invalid_invite_still_creates_user()
    {
        putenv('ADMIN_INVITE_TOKEN=admintoken123');

        $response = $this->post(route('register'), [
            'name' => 'Nope Admin',
            'email' => 'nope@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'invite_token' => 'wrongtoken',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'nope@example.com',
            'role' => 'user',
        ]);
    }
}
