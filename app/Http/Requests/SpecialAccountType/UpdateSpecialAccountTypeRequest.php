<?php

namespace App\Http\Requests\SpecialAccountType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecialAccountTypeRequest extends FormRequest
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
            'special_account_type_name' => 'required|string|max:255|unique:special_account_types,special_account_type_name,' .  $this->route('special_account_type')->id,
        ];
    }
}
