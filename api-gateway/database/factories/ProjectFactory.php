<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $availableNumbers = [1, 2, 3];

    public function definition(): array
    {
        $uniqueNumber = array_pop($this->availableNumbers);

        return [
            'year'              => $this->faker->numberBetween(2000, date('Y')),
            'project_name'      => $this->faker->unique()->randomElement(['ITS Tools', 'LSoft', 'i-Chain Brave']),
            'contract_number'   => $this->faker->randomNumber(5),
            'customer_id'       => 2,
            'payment_status'    => 0,
            'marketing_name'    => $this->faker->name(),
            'start_date'        => $this->faker->date('Y-m-d'),
            'end_date'          => $this->faker->date('Y-m-d'),
            'contract_status'   => 0,
            'department_id'     => $uniqueNumber,
            'user_id'           => NULL,
        ];
    }
}
