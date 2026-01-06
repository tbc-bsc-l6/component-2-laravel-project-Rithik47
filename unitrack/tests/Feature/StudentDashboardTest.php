<?php

namespace Tests\Feature;

use App\Models\Enrolment;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_sees_current_available_and_history()
    {
        $user = User::factory()->create(['role' => 'user']);

        // Current enrolment
        $currentEnrol = Enrolment::factory()->create([
            'user_id' => $user->id,
            'status' => Enrolment::STATUS_PENDING,
            'completed_at' => null,
        ]);

        // Completed enrolment
        $completedEnrol = Enrolment::factory()->create([
            'user_id' => $user->id,
            'status' => Enrolment::STATUS_PASS,
            'completed_at' => now(),
        ]);

        // Available module
        $available = Module::factory()->create(['is_archived' => false]);

        // Archived module (should not appear)
        $archived = Module::factory()->create(['is_archived' => true]);

        // Full module (10 active students)
        $full = Module::factory()->create(['is_archived' => false]);
        Enrolment::factory()->count(10)->create(['module_id' => $full->id, 'status' => Enrolment::STATUS_PENDING, 'completed_at' => null]);

        $this->actingAs($user)
            ->get(route('student.dashboard'))
            ->assertStatus(200)
            ->assertSee($currentEnrol->module->code)
            ->assertSee($completedEnrol->module->code)
            ->assertSee($available->code)
            ->assertDontSee($archived->code)
            ->assertDontSee($full->code);
    }

    public function test_old_student_sees_only_history()
    {
        $user = User::factory()->create(['role' => 'old_student']);

        $completedEnrol = Enrolment::factory()->create([
            'user_id' => $user->id,
            'status' => Enrolment::STATUS_PASS,
            'completed_at' => now(),
        ]);

        $pendingEnrol = Enrolment::factory()->create([
            'user_id' => $user->id,
            'status' => Enrolment::STATUS_PENDING,
            'completed_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('student.dashboard'))
            ->assertStatus(200)
            ->assertSee($completedEnrol->module->code)
            ->assertDontSee($pendingEnrol->module->code)
            ->assertDontSee('Enrol');
    }

    public function test_student_nav_link_visible_to_students()
    {
        $student = User::factory()->create(['role' => 'user']);

        $this->actingAs($student)
            ->get(route('modules.index'))
            ->assertSee('Student Dashboard');

        $teacher = User::factory()->create(['role' => 'teacher']);
        $this->actingAs($teacher)
            ->get(route('modules.index'))
            ->assertDontSee('Student Dashboard');
    }
}
