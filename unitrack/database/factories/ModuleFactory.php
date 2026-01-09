<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(
                $this->faker->unique()->bothify('???###')
            ),
            'name' => $this->faker->sentence(3),
            'is_archived' => $this->faker->boolean(10),
        ];
    }
}
