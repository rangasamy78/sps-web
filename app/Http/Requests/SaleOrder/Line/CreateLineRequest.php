<?php

namespace App\Http\Requests\SaleOrder\Line;

use Illuminate\Foundation\Http\FormRequest;

class CreateLineRequest extends FormRequest
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
            'item_id'     => 'required|integer',
            'item_description'    => 'required_if:is_sold_as,1',
        ];
    }
    public function messages(): array
    {
        return [
            'item_id'    => 'Please select any',
            'item_description'   => 'The description is required.',
        ];
    }
}
