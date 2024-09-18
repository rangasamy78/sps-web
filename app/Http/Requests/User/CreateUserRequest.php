<?php
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to this request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => 'required|string|max:255|unique:users,name',
            'code'                  => 'required|string|max:255|unique:users,code',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
            'department_id'         => 'required|exists:departments,id',
            'designation_id'        => 'required|exists:designations,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'                  => 'The name field is required.',
            'name.unique'                    => 'The name has already been taken.',
            'code.required'                  => 'The code field is required.',
            'code.unique'                    => 'The code has already been taken.',
            'email.required'                 => 'The email field is required.',
            'email.email'                    => 'The email must be a valid email address.',
            'email.unique'                   => 'The email has already been taken.',
            'password.required'              => 'The password field is required.',
            'password.min'                   => 'The password must be at least :min characters.',
            'password.confirmed'             => 'The password confirmation does not match.',
            'password_confirmation.required' => 'The confirm password field is required.',
            'department_id.required'         => 'The department field is required.',
            'department_id.exists'           => 'The selected department does not exist.',
            'designation_id.required'        => 'The designation field is required.',
            'designation_id.exists'          => 'The selected designation does not exist.',
        ];
    }
}
