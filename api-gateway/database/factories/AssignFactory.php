<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assign>
 */
class AssignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $availableNumbers = ["J0001", "J0002", "J0003"];
    protected $availableMaketingStatus = ["available", "not available", "available"];

    public function definition(): array
    {
        $uniqueNumber = array_pop($this->availableNumbers);
        $uniqueStatus = array_pop($this->availableMaketingStatus);
        $s1 = ["project_type" => 1, "customer_id" => "000044", "project_id" => 2, "role" => 1, "man_month" => 1, "unit_price" => 5, "member_type" => 1,];
        $s2 = ["project_type" => 2, "customer_id" => "000052", "project_id" => 1, "role" => 2, "man_month" => 3, "unit_price" => 1, "member_type" => 3,];
        $s3 = ["project_type" => 3, "customer_id" => "000057", "project_id" => 2, "role" => 3, "man_month" => 2, "unit_price" => 7, "member_type" => 3,];
        $s4 = ["project_type" => 2, "customer_id" => "000003", "project_id" => 3, "role" => 1, "man_month" => 4, "unit_price" => 9, "member_type" => 1,];
        $s5 = ["project_type" => 4, "customer_id" => "000063", "project_id" => 1, "role" => 1, "man_month" => 8, "unit_price" => 10, "member_type" => 2,];
        return [
            'employee_code' => $uniqueNumber,
            'january' => json_encode([$s1, $s5]),
            'february' => json_encode([]),
            'march' => json_encode([$s4]),
            'april' => json_encode([$s2, $s3]),
            'may' => json_encode([]),
            'june' => json_encode([$s1]),
            'july' => json_encode([]),
            'august' => json_encode([$s1]),
            'september' => json_encode([]),
            'october' => json_encode([]),
            'november' => json_encode([$s1]),
            'december' => json_encode([$s4]),
            'marketing_status' => $uniqueStatus,
            'proposal_status' => "Assign in IChain Project",
            'careersheet_status' => 0,
            'careersheet_link' => "https://www.example.com/careersheet.pdf",
            'man_month' => 1,
            'unit_price' => 10,
            'year' => '2023',
            'user_id' => NULL
        ];
    }
}
