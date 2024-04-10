<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractApiRequest;

class ProjectAssignRequest extends AbstractApiRequest
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
            'marketing_status' => 'required',
            'proposal_status' => 'max:255',
            'careersheet_status' => 'max:11',
            'careersheet_link' => 'max:255',
            'january' => 'max:255',
            'february' => 'max:255',
            'march' => 'max:255',
            'april' => 'max:255',
            'may' => 'max:255',
            'june' => 'max:255',
            'july' => 'max:255',
            'august' => 'max:255',
            'september' => 'max:255',
            'october' => 'max:255',
            'november' => 'max:255',
            'december' => 'max:255',
            'employee_code' => 'required|max:10',
            'year' => 'required|max:11',
            'user_id' => 'max:11',
            'update_flag' => 'max:11',
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
            'careersheet_status.max' => 'please fill careersheet status field within 255 words',
            'proposal_status.max' => 'please fill prosal status field within 255 words',
            'career_link.max' => 'please fill career sheet link field within 255 words',
            'employee_code.required' => 'please fill employee field',
            'marketing_status.required' => 'please fill marketing field',
            'year.required' => 'please fill year field'
        ];
    }
}
