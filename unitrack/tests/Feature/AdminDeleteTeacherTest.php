<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDeleteTeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_teacher_and_unassign_modules()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $module = Module::factory()->create(['teacher_id' => $teacher->id]);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $teacher))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', 'Teacher account deleted.');

        $this->assertDatabaseMissing('users', ['id' => $teacher->id]);
        $this->assertDatabaseHas('modules', ['id' => $module->id, 'teacher_id' => null]);
    }

    public function test_admin_cannot_delete_self()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertStatus(400);
    }

    public function test_non_admin_cannot_delete_teacher()
    {
        $user = User::factory()->create(['role' => 'user']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($user)
            ->delete(route('admin.users.destroy', $teacher))
            ->assertStatus(403);
    }

    public function test_ajax_delete_returns_json()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($admin)
            ->deleteJson(route('admin.users.destroy', $teacher))
            ->assertOk()
            ->assertJson(['message' => 'Teacher deleted']);
    }
}
