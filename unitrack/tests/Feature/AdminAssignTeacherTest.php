<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAssignTeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_assign_page_and_update_teacher()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.modules.teacher.edit', $module));
        $response->assertStatus(200);
        $response->assertSee('Assign Teacher');

        $post = $this->actingAs($admin)->patch(route('admin.modules.teacher.update', $module), [
            'teacher_id' => $teacher->id,
        ]);

        $post->assertRedirect(route('admin.modules.index'));
        $this->assertEquals($teacher->id, $module->fresh()->teacher_id);
    }

    public function test_admin_can_assign_via_ajax()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create();

        $response = $this->actingAs($admin)->patchJson(route('admin.modules.teacher.update', $module), [
            'teacher_id' => $teacher->id,
        ]);

        $response->assertOk()->assertJson(['status' => 'ok']);
        $this->assertEquals($teacher->id, $module->fresh()->teacher_id);
    }

    public function test_non_admin_cannot_assign_via_ajax()
    {
        $user = User::factory()->create(['role' => 'user']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('admin.modules.teacher.update', $module), [
            'teacher_id' => $teacher->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_access_assign_page()
    {
        $user = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.modules.teacher.edit', $module));
        $response->assertStatus(403);
    }
}
