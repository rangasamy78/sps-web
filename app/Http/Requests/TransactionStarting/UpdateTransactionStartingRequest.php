<?php

namespace App\Http\Requests\TransactionStarting;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionStartingRequest extends FormRequest
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
        $transaction = $this->route('transaction_starting');

        return [
            'type'            => [
                'required',
                'string',
                Rule::unique('transaction_startings')->ignore($transaction->id),
            ],
            'starting_number' => [
                'required',
                'numeric',
                Rule::unique('transaction_startings')
                    ->where(function ($query) {
                        return $query->where('type', $this->input('type'));
                    })
                    ->ignore($transaction->id),
            ],
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
            'type.required'            => 'The type field is required.',
            'type.string'              => 'The type must be a string.',
            'type.max'                 => 'The type may not be greater than :max characters.',
            'type.unique'              => 'The type has already been taken.',
            'starting_number.required' => 'The starting number field is required.',
            'starting_number.numeric'  => 'The starting number must be a number.',
            'starting_number.max'      => 'The starting number may not be greater than :max characters.',
            'starting_number.unique'   => 'The starting number has already been taken for the selected type.',
        ];
    }
}
