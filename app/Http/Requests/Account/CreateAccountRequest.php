<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
    public function rules()
    {
        return [
            'account_name'                     => 'required|string|max:255',
            'account_number'                   => 'required|string|max:50|unique:accounts,account_number',
            'account_type_id'                  => 'required|integer',
            'account_sub_type_id'              => 'nullable|integer',
            'special_account_type_id'          => 'nullable|integer',
            'account_operating_location_id'    => 'nullable|integer',
            'alternate_number'                 => 'nullable|string|max:50',
            'alternate_name'                   => 'nullable|string|max:255',
            'is_sub_account_of_id'             => 'nullable|integer',
            'currency_id'                      => 'required|integer',
            'statement_end_day'                => 'nullable|string',
            'is_default_account'               => 'nullable|boolean',
            'is_budgeted_account'              => 'nullable|boolean',
            'is_tax_account'                   => 'nullable|boolean',
            'is_reconciled_account'            => 'nullable|boolean',
            'is_allow_bank_reconciliation'     => 'nullable|boolean',
            'bank_name'                        => 'nullable|string|max:255',
            'branch_name'                      => 'nullable|string|max:255',
            'manager_name'                     => 'nullable|string|max:255',
            'phone'                            => 'nullable|string|max:50',
            'fax'                              => 'nullable|string|max:50',
            'website'                          => 'nullable|url|max:255',
            'swift_code'                       => 'nullable|string|max:11',
            'routing_number'                   => 'nullable|string|max:50',
            'bank_account_number'              => 'nullable|string|max:50',
            'is_allow_printing_checks'         => 'nullable|boolean',
            'internal_notes'                   => 'nullable|string',
            'status'                           => 'required',
        ];
    }

    public function messages()
    {
        return [
            'account_name.required'            => 'The account name is required.',
            'account_number.required'          => 'The account number is required.',
            'account_number.unique'            => 'The account number must be unique.',
            'account_type_id.required'         => 'The account type is required.',
            'currency_id.required'             => 'The currency is required.',
            'bank_name.required'               => 'The bank name is required.',
        ];
    }
}
