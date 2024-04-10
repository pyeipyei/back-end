<?php

namespace App\Http\Requests;

class RegisterRequest extends AbstractApiRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email:rfc,dns||max:50|unique:users,email',
            'employee_id' => 'required|string|max:25|unique:users,employee_id',
            'password' => 'required|min:3',
            'confirmPassword' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The user name field is required.',
            'email.regex' => 'The user email field is required.',
            'employee_id.required' => 'The employee Id field is required.',
            'password.required' => 'Password field is required.',
            'confirmPassword.required' => 'Confirm Password field is required.',
        ];
    }
}
