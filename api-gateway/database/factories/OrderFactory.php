<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'project_type_id'                   => 1,
            'ses_project_leader'                => $this->faker->name(),
            'ses_estimate_number'               => $this->faker->randomNumber(8),
            'ses_approval_number'               => $this->faker->randomNumber(5),
            'ses_order_number'                  => $this->faker->randomNumber(5),
            'ses_delivery_date'                 => $this->faker->date('Y-m-d'),
            'ses_pm_man_month'                  => 1,
            'ses_pm_average_unit_price'         => 5000,
            'ses_pl_man_month'                  => 1,
            'ses_pl_average_unit_price'         => 2000,
            'ses_se_man_month'                  => 5,
            'ses_se_average_unit_price'         => 1000,
            'ses_pg_man_month'                  => 5,
            'ses_pg_average_unit_price'         => 800,
            'ses_oh_man_month'                  => 2,
            'ses_oh_average_unit_price'         => 400,
            'ses_order_amount'                  => 16800,
            'ses_acceptance_billing_date'       => $this->faker->date('Y-m-d'),
            'ses_payment_date'                  => $this->faker->date('Y-m-d'),
            'jp_project_leader'                 => NULL,
            'jp_estimate_number'                => NULL,
            'jp_approval_number'                => NULL,
            'jp_order_number'                   => NULL,
            'jp_delivery_date'                  => NULL,
            'jp_pm_man_month'                   => NULL,
            'jp_pm_average_unit_price'          => NULL,
            'jp_pl_man_month'                   => NULL,
            'jp_pl_average_unit_price'          => NULL,
            'jp_se_man_month'                   => NULL,
            'jp_se_average_unit_price'          => NULL,
            'jp_pg_man_month'                   => NULL,
            'jp_pg_average_unit_price'          => NULL,
            'jp_oh_man_month'                   => NULL,
            'jp_oh_average_unit_price'          => NULL,
            'jp_order_amount'                   => NULL,
            'jp_acceptance_billing_date'        => NULL,
            'jp_payment_date'                   => NULL,
            'mm_project_leader'                 => NULL,
            'mm_estimate_number'                => NULL,
            'mm_approval_number'                => NULL,
            'mm_order_number'                   => NULL,
            'mm_delivery_date'                  => NULL,
            'mm_pm_man_month'                   => NULL,
            'mm_pm_average_unit_price'          => NULL,
            'mm_pl_man_month'                   => NULL,
            'mm_pl_average_unit_price'          => NULL,
            'mm_se_man_month'                   => NULL,
            'mm_se_average_unit_price'          => NULL,
            'mm_pg_man_month'                   => NULL,
            'mm_pg_average_unit_price'          => NULL,
            'mm_oh_man_month'                   => NULL,
            'mm_oh_average_unit_price'          => NULL,
            'mm_gicj_fee'                       => NULL,
            'mm_order_amount'                   => NULL,
            'mm_billing_amount'                 => NULL,
            'mm_acceptance_billing_date'        => NULL,
            'mm_payment_date'                   => NULL,
            'project_id'                        => $uniqueNumber,
        ];
    }
}
