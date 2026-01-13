<?php

namespace Tests\Feature;

use App\Models\Enrolment;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_student_to_module()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.modules.students.store', $module), [
                'user_id' => $student->id,
            ])
            ->assertRedirect(route('admin.modules.show', $module))
            ->assertSessionHas('status', 'Student added to module.');

        $this->assertDatabaseHas('enrolments', [
            'user_id' => $student->id,
            'module_id' => $module->id,
            'status' => Enrolment::STATUS_PENDING,
        ]);
    }

    public function test_admin_cannot_add_same_student_twice()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        Enrolment::create([
            'user_id' => $student->id,
            'module_id' => $module->id,
            'status' => Enrolment::STATUS_PENDING,
            'started_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.modules.students.store', $module), [
                'user_id' => $student->id,
            ])
            ->assertRedirect()
            ->assertSessionHas('error', 'Student is already enrolled in this module.');
    }

    public function test_non_admin_cannot_add_student()
    {
        $user = User::factory()->create(['role' => 'user']);
        $student = User::factory()->create(['role' => 'user']);
        $module = Module::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.modules.students.store', $module), [
                'user_id' => $student->id,
            ])
            ->assertStatus(403);
    }
}
