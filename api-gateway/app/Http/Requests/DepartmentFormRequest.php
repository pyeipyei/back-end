<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractApiRequest;
class DepartmentFormRequest extends AbstractApiRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'department_name' => ['required', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'marketing_name' => 'required',
            'department_head' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'department_name.required' => 'The department name field is required.',
            'department_name.regex' => 'The department name field does not allow special characters.',           
            'marketing_name.required' => 'The marketing name field is required.',           
            'department_head.required' => 'The department head field is required.',            
        ];
    }
}
