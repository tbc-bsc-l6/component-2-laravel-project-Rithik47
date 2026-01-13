<?php

namespace Database\Factories;

use App\Models\Enrolment;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrolmentFactory extends Factory
{
    protected $model = Enrolment::class;

    public function definition()
    {
        $user = User::factory()->create();
        $module = Module::factory()->create();

        return [
            'user_id' => $user->id,
            'module_id' => $module->id,
            'started_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'status' => $this->faker->randomElement([Enrolment::STATUS_PENDING, Enrolment::STATUS_PASS, Enrolment::STATUS_FAIL]),
            'completed_at' => $this->faker->optional(0.6)->dateTimeBetween('-30 days', 'now'),
        ];
    }
}

