<?php

namespace App\Http\Requests\SubHeading;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubHeadingRequest extends FormRequest
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
            'sub_heading_name' => 'required|string|max:255|unique:sub_headings,sub_heading_name,',
        ];
    }
}
