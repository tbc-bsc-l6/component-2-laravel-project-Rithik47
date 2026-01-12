<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NonAdminModulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_see_delete_button()
    {
        $user = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $response = $this->actingAs($user)->get(route('modules.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Delete');
    }

    public function test_non_admin_cannot_delete_module()
    {
        $user = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $response = $this->actingAs($user)->delete(route('modules.destroy', $module));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('modules', ['id' => $module->id]);
    }
}