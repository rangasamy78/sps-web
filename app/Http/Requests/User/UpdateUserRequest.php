<?php
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user');
        return [
            'first_name'           => 'required|string|max:255|unique:users,first_name,' . $userId->id,
            'code'           => 'nullable|string|max:255|unique:users,code,' . $userId->id,
            'email'          => 'required|email|unique:users,email,' . $userId->id,
            'password'       => 'confirmed',
            'department_id'  => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
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
            'first_name.required'           => 'The first name field is required.',
            'first_name.unique'             => 'The last name has already been taken.',
            'code.required'           => 'The code field is required.',
            'code.unique'             => 'The code has already been taken.',
            'email.required'          => 'The email field is required.',
            'email.email'             => 'The email must be a valid email address.',
            'email.unique'            => 'The email has already been taken.',
            'password.confirmed'      => 'The password confirmation does not match.',
            'department_id.required'  => 'The department field is required.',
            'department_id.exists'    => 'The selected department does not exist.',
            'designation_id.required' => 'The designation field is required.',
            'designation_id.exists'   => 'The selected designation does not exist.',
        ];
    }
}
