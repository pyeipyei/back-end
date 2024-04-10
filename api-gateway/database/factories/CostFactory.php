<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cost>
 */
class CostFactory extends Factory
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
            'estimate_cost'           => 16800,
            'actual_cost'       => 0,
            'project_id'        => $uniqueNumber,
        ];
    }
}
