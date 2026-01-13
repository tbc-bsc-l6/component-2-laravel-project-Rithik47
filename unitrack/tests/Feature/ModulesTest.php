<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_modules()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $modules = Module::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('modules.index'));

        $response->assertStatus(200);
        foreach ($modules as $module) {
            $response->assertSee($module->code);
            $response->assertSee($module->name);
        }
    }

    public function test_create_page_displays_form()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get(route('modules.create'));

        $response->assertStatus(200);
        $response->assertSee('Create Module');
        $response->assertSee('name="code"', false);
        $response->assertSee('name="name"', false);
    }

    public function test_store_creates_module()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $data = [
            'code' => 'ABC101',
            'name' => 'Intro to ABC',
            'is_archived' => false,
        ];

        $response = $this->actingAs($user)->post(route('modules.store'), $data);

        $response->assertRedirect(route('modules.index'));
        $this->assertDatabaseHas('modules', ['code' => 'ABC101', 'name' => 'Intro to ABC']);
    }

    public function test_show_displays_module()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $module = Module::factory()->create();

        $response = $this->actingAs($user)->get(route('modules.show', $module));

        $response->assertStatus(200);
        $response->assertSee($module->code);
        $response->assertSee($module->name);
    }

    public function test_edit_page_displays_values()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $module = Module::factory()->create();

        $response = $this->actingAs($user)->get(route('modules.edit', $module));

        $response->assertStatus(200);
        $response->assertSee('Edit Module');
        $response->assertSee('value="' . e($module->code) . '"', false);
        $response->assertSee('value="' . e($module->name) . '"', false);
    }

    public function test_update_changes_module()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $module = Module::factory()->create(['code' => 'OLD', 'name' => 'Old Name']);

        $data = ['code' => 'NEW101', 'name' => 'New Name', 'is_archived' => true];

        $response = $this->actingAs($user)->put(route('modules.update', $module), $data);

        $response->assertRedirect(route('modules.index'));
        $this->assertDatabaseHas('modules', ['id' => $module->id, 'code' => 'NEW101', 'name' => 'New Name', 'is_archived' => 1]);
    }

    public function test_destroy_deletes_module()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $module = Module::factory()->create();

        $response = $this->actingAs($user)->delete(route('modules.destroy', $module));

        $response->assertRedirect(route('modules.index'));
        $this->assertDatabaseMissing('modules', ['id' => $module->id]);
    }
}
