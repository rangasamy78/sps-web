<?php

namespace App\Http\Requests\AccountSubType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountSubTypeRequest extends FormRequest
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
            'sub_type_name' => 'required|string|max:255|unique:account_sub_types,sub_type_name,' . $this->route('account_sub_type')->id
        ];
    }
}
