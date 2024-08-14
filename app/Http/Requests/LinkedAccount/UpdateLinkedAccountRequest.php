<?php

namespace App\Http\Requests\LinkedAccount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLinkedAccountRequest extends FormRequest
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
        $linkedAccount = $this->route('linked_account')->id;
        return [
            'account_code' => 'required|string|unique:linked_accounts,account_code,' . $linkedAccount,
            'account_name' => 'required|string|max:255|unique:linked_accounts,account_name,' . $linkedAccount,
            'account_type' => 'required|integer',
            'account_sub_type' => 'required|integer',
        ];
    }
}
