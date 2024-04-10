<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractApiRequest;

class ProjectTypeRequest extends  AbstractApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
       return [
            'project_type' => ['required', 'regex:/^[a-zA-Z0-9\s]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'project_type.required' => 'The project type field is required.',
            'project_type.regex' => 'The project type field does not allow special characters.',
        ];
    }
}
