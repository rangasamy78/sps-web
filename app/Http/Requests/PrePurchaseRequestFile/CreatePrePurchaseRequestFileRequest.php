<?php

namespace App\Http\Requests\PrePurchaseRequestFile;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrePurchaseRequestFileRequest extends FormRequest
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
            'images'   => ['required', 'array'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Image is required.',
            'images.*.required' => 'Each image is required.',
            'images.*.mimes' => 'Each image must be of type: jpg, jpeg, png, gif.',
            'images.*.max' => 'Each image must not be greater than 2MB.',
        ];
    }
}
