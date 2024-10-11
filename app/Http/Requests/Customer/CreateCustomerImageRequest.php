<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerImageRequest extends FormRequest
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
            'customer_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'customer_image.required' => 'The customer image is required.',
            'customer_image.image' => 'The file must be an image.',
            'customer_image.mimes' => 'The image must be a file of type: jpg, jpeg, png, gif.',
            // 'customer_image.max' => 'The image must not be greater than 2MB.',
            // 'customer_image.dimensions' => 'The image must be at least 100x100 pixels.',
        ];
    }
}
