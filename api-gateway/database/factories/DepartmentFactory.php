<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_name'   => $this->faker->unique()->randomElement(['Marketing', 'IT', 'Sales']),
            'marketing_name'    => "201501",
            'department_head'   => "J0001",
            'user_id'           => NULL,
        ];
    }
}
