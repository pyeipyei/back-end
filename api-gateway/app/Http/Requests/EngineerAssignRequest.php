<?php

namespace App\Http\Requests;
use App\Http\Requests\AbstractApiRequest;

class EngineerAssignRequest extends AbstractApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'project_id' => 'required',
            'projectEmployees.*.member_type' => 'max:11',
            'projectEmployees.*.role' => 'required',
            'projectEmployees.*.man_month' => 'required|max:11',
            'projectEmployees.*.unit_price' => 'required|max:11',
            'start_date' => 'required',
            'end_date' => 'required',
            'projectEmployees' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company_id.required' => 'please fill company field',
            'project_id.required' => 'please fill project field',
            'role.required' => 'please fill role field',
            'man_month.required' => 'please fill work hour field',
            'unit_price.required' => 'please fill unit price field',
            'start_date.required' => 'please fill start date field',
            'end_date.required' => 'please fill end date field',
            'assign.unique' => 'this employees have already exit'
        ];
    }
}
