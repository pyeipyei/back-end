<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractApiRequest;

class RoleFormRequest extends AbstractApiRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
       return [
            'role_name' => ['required', 'regex:/^[a-zA-Z0-9\s]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'role_name.required' => 'The role name field is required.',
            'role_name.regex' => 'The role name field does not allow special characters.',
        ];
    }
}
