<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuleTeacherAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_teacher_to_module()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $module = Module::factory()->create();

        $module->teacher()->associate($teacher);
        $module->save();

        $this->assertEquals($teacher->id, $module->fresh()->teacher_id);
    }
}
