<?php

namespace Tests\Feature;

use App\Models\Enrolment;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_view_assigned_modules_and_students()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create(['teacher_id' => $teacher->id]);
        $enrol = Enrolment::factory()->create(['module_id' => $module->id]);

        $response = $this->actingAs($teacher)->get(route('teacher.modules.index'));
        $response->assertStatus(200);
        $response->assertSee($module->code);

        $response = $this->actingAs($teacher)->get(route('teacher.modules.show', $module));
        $response->assertStatus(200);
        $response->assertSee($enrol->user->name);
    }

    public function test_teacher_can_grade_student_and_timestamp_completed_at()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create(['teacher_id' => $teacher->id]);
        $enrol = Enrolment::factory()->create(['module_id' => $module->id, 'status' => Enrolment::STATUS_PENDING, 'completed_at' => null]);

        $response = $this->actingAs($teacher)->post(route('teacher.modules.enrolments.grade', [$module, $enrol]), ['status' => 'pass']);
        $response->assertRedirect(route('teacher.modules.show', $module));

        $this->assertDatabaseHas('enrolments', ['id' => $enrol->id, 'status' => Enrolment::STATUS_PASS]);
        $this->assertNotNull($enrol->fresh()->completed_at);
    }

    public function test_teacher_cannot_grade_for_unassigned_module()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create();
        $enrol = Enrolment::factory()->create(['module_id' => $module->id]);

        $response = $this->actingAs($teacher)->post(route('teacher.modules.enrolments.grade', [$module, $enrol]), ['status' => 'pass']);
        $response->assertStatus(403);
    }

    public function test_teacher_can_grade_via_ajax()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create(['teacher_id' => $teacher->id]);
        $enrol = Enrolment::factory()->create(['module_id' => $module->id, 'status' => Enrolment::STATUS_PENDING, 'completed_at' => null]);

        $response = $this->actingAs($teacher)->postJson(route('teacher.modules.enrolments.grade', [$module, $enrol]), ['status' => 'pass']);
        $response->assertOk()->assertJson(['message' => 'Student graded.', 'status' => Enrolment::STATUS_PASS]);

        $this->assertDatabaseHas('enrolments', ['id' => $enrol->id, 'status' => Enrolment::STATUS_PASS]);
    }

    public function test_non_teacher_cannot_access_teacher_routes()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('teacher.modules.index'));
        $response->assertStatus(403);
    }
}
