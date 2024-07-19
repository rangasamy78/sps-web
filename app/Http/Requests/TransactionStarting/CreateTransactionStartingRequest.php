<?php

namespace App\Http\Requests\TransactionStarting;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\TransactionStarting;

class CreateTransactionStartingRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                Rule::unique('transaction_startings')->where(function ($query) {
                    return $query->where('starting_number', $this->input('starting_number'));
                }),
            ],
            'starting_number' => [
                'required',
                'numeric',  // Ensure starting_number is a valid number
                Rule::unique('transaction_startings')->where(function ($query) {
                    return $query->where('type', $this->input('type'));
                }),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Type is required.',
            'type.unique' => 'The combination of Type and Starting Number has already been taken.',
            'starting_number.required' => 'Starting Number is required.',
            'starting_number.numeric' => 'Starting Number must be a valid number.',  // Custom error message for numeric validation
            'starting_number.unique' => 'The combination of Type and Starting Number has already been taken.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $this->checkTypeWithDifferentStartingNumber($validator);
        });
    }

    /**
     * Custom validation rule to check if type already exists with a different starting number.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function checkTypeWithDifferentStartingNumber($validator)
    {
        $type = $this->input('type');
        $startingNumber = $this->input('starting_number');
        $existingRecord = TransactionStarting::where('type', $type)
            ->where('starting_number', '!=', $startingNumber)
            ->first();

        if ($existingRecord) {
            $validator->errors()->add('type', 'A record with the same Type but a different Starting Number already exists.');
        }
    }
}





