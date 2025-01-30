<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity'    => 'required|numeric',
            'unit_price'  => 'required|numeric',
            'extended'    => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required'   => 'The quantity field is required.',
            'quantity.numeric'    => 'The quantity must be a valid number.',
            
            'unit_price.required' => 'The unit price field is required.',
            'unit_price.numeric'  => 'The unit price must be a valid number.',
           

            'extended.required'   => 'The extended price field is required.',
            'extended.numeric'    => 'The extended price must be a valid number.',
           
        ];
    }
}
