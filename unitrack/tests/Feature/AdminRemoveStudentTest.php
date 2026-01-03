<?php

namespace Tests\Feature;

use App\Models\Enrolment;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRemoveStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_remove_student_from_module()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $enrol = Enrolment::factory()->create([
            'user_id' => $student->id,
            'module_id' => $module->id,
            'status' => Enrolment::STATUS_PENDING,
            'completed_at' => null,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.modules.students.destroy', [$module, $enrol]))
            ->assertRedirect(route('admin.modules.show', $module))
            ->assertSessionHas('status', 'Student removed from module.');

        $this->assertDatabaseMissing('enrolments', ['id' => $enrol->id]);
    }

    public function test_admin_can_remove_student_via_ajax()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $enrol = Enrolment::factory()->create([
            'user_id' => $student->id,
            'module_id' => $module->id,
            'status' => Enrolment::STATUS_PENDING,
            'completed_at' => null,
        ]);

        $this->actingAs($admin)
            ->deleteJson(route('admin.modules.students.destroy', [$module, $enrol]))
            ->assertOk()
            ->assertJson(['message' => 'Student removed']);

        $this->assertDatabaseMissing('enrolments', ['id' => $enrol->id]);
    }

    public function test_non_admin_cannot_remove_student()
    {
        $user = User::factory()->create(['role' => 'user']);
        $student = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $enrol = Enrolment::factory()->create(['user_id' => $student->id, 'module_id' => $module->id]);

        $this->actingAs($user)
            ->delete(route('admin.modules.students.destroy', [$module, $enrol]))
            ->assertStatus(403);
    }
}
