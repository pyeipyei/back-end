<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectType>
 */
class ProjectTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;
        $options = ['SES', 'Offshore(Japan)', 'Offshore(Myanmar)', 'Offshore(Japan+Myanmar)'];
        return [
            'project_type' => $options[$index++ % count($options)],
        ];
    }
}
