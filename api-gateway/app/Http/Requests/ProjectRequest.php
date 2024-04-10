<?php

namespace App\Http\Requests;

class ProjectRequest extends AbstractApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            // validation for projects table
            "year"                          => "required|date_format:Y",
            "project_name"                  => "required",
            "contract_number"               => "nullable",
            "customer_id"                   => "required",
            "payment_status"                => "required|numeric|min:0",
            "department_id"                 => "required",
            "marketing_name"                => "required",
            "start_date"                    => "nullable",
            "end_date"                      => "nullable",
            "contract_status"               => "required|numeric|min:0",
            "user_id"                       => "nullable",

            // validation for orders table
            "project_type_id"               => "required|numeric",
            "ses_project_leader"            => "nullable|string",
            "ses_estimate_number"           => "nullable|string",
            "ses_approval_number"           => "nullable|string",
            "ses_order_number"              => "nullable|string",
            "ses_delivery_date"             => "nullable",
            "ses_pm_man_month"              => "nullable|numeric",
            "ses_pm_average_unit_price"     => "nullable|numeric",
            "ses_pl_man_month"              => "nullable|numeric",
            "ses_pl_average_unit_price"     => "nullable|numeric",
            "ses_se_man_month"              => "nullable|numeric",
            "ses_se_average_unit_price"     => "nullable|numeric",
            "ses_pg_man_month"              => "nullable|numeric",
            "ses_pg_average_unit_price"     => "nullable|numeric",
            "ses_oh_man_month"              => "nullable|numeric",
            "ses_oh_average_unit_price"     => "nullable|numeric",
            "ses_order_amount"              => "nullable|numeric",
            "ses_acceptance_billing_date"   => "nullable",
            "ses_payment_date"              => "nullable",
            "jp_project_leader"             => "nullable|string",
            "jp_estimate_number"            => "nullable|string",
            "jp_approval_number"            => "nullable|string",
            "jp_order_number"               => "nullable|string",
            "jp_delivery_date"              => "nullable",
            "jp_pm_man_month"               => "nullable|numeric",
            "jp_pm_average_unit_price"      => "nullable|numeric",
            "jp_pl_man_month"               => "nullable|numeric",
            "jp_pl_average_unit_price"      => "nullable|numeric",
            "jp_se_man_month"               => "nullable|numeric",
            "jp_se_average_unit_price"      => "nullable|numeric",
            "jp_pg_man_month"               => "nullable|numeric",
            "jp_pg_average_unit_price"      => "nullable|numeric",
            "jp_oh_man_month"               => "nullable|numeric",
            "jp_oh_average_unit_price"      => "nullable|numeric",
            "jp_order_amount"               => "nullable|numeric",
            "jp_acceptance_billing_date"    => "nullable",
            "jp_payment_date"               => "nullable",
            "mm_project_leader"             => "nullable|string",
            "mm_estimate_number"            => "nullable|string",
            "mm_approval_number"            => "nullable|string",
            "mm_order_number"               => "nullable|string",
            "mm_delivery_date"              => "nullable",
            "mm_pm_man_month"               => "nullable|numeric",
            "mm_pm_average_unit_price"      => "nullable|numeric",
            "mm_pl_man_month"               => "nullable|numeric",
            "mm_pl_average_unit_price"      => "nullable|numeric",
            "mm_se_man_month"               => "nullable|numeric",
            "mm_se_average_unit_price"      => "nullable|numeric",
            "mm_pg_man_month"               => "nullable|numeric",
            "mm_pg_average_unit_price"      => "nullable|numeric",
            "mm_oh_man_month"               => "nullable|numeric",
            "mm_oh_average_unit_price"      => "nullable|numeric",
            "mm_gicj_fee"                   => "nullable|numeric",
            "mm_order_amount"               => "nullable|numeric",
            "mm_billing_amount"             => "nullable|numeric",
            "mm_acceptance_billing_date"    => "nullable",
            "mm_payment_date"               => "nullable",

            // validation for costs table
           
            "estimate_cost"               => "numeric",
            "actual_cost"           => "numeric",
        ];
    }

    public function messages()
    {
        return [
            "customer_id.required"      => "The customer name field is required.",
            "department_id.required"    => "The department name field is required.",
            "project_type_id.required"  => "The project type field is required.",
        ];
    }
}
