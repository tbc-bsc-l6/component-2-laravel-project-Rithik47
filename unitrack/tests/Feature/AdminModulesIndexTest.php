<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModulesIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_modules_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Module::factory()->count(3)->create();

        $response = $this->actingAs($admin)->get(route('admin.modules.index'));
        $response->assertStatus(200);
        $response->assertSee('Manage Modules');
    }

    public function test_non_admin_cannot_view_index()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('admin.modules.index'));
        $response->assertStatus(403);
    }
}
