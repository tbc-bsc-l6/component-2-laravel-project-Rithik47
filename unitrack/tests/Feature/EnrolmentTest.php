<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use App\Models\Enrolment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrolmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_enrol_when_slots_available()
    {
        $user = User::factory()->create();
        $module = Module::factory()->create(['is_archived' => false]);

        $response = $this->actingAs($user)->post(route('modules.enrol', $module));

        $response->assertRedirect(route('modules.show', $module));
        $this->assertDatabaseHas('enrolments', ['user_id' => $user->id, 'module_id' => $module->id]);
    }

    public function test_cannot_enrol_if_module_is_archived()
    {
        $user = User::factory()->create();
        $module = Module::factory()->create(['is_archived' => true]);

        $response = $this->actingAs($user)->post(route('modules.enrol', $module));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('enrolments', ['user_id' => $user->id, 'module_id' => $module->id]);
    }

    public function test_cannot_enrol_if_module_full()
    {
        $module = Module::factory()->create(['is_archived' => false]);
        // create 10 active enrolments
        Enrolment::factory()->count(10)->create(['module_id' => $module->id, 'completed_at' => null]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('modules.enrol', $module));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_cannot_enrol_if_user_has_max_active_modules()
    {
        $user = User::factory()->create();
        // create 4 active enrolments for the user
        Enrolment::factory()->count(4)->create(['user_id' => $user->id, 'completed_at' => null]);

        $module = Module::factory()->create();
        $response = $this->actingAs($user)->post(route('modules.enrol', $module));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
