<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_get_shows_combined_page()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertSee('Unitrack');
        $response->assertSee('Log in');
        $response->assertSee('Start here');
    }

    public function test_register_get_shows_combined_page()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertSee('Unitrack');
        $response->assertSee('Start here');
    }
}
