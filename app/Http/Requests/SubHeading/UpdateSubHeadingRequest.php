<?php

namespace App\Http\Requests\SubHeading;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubHeadingRequest extends FormRequest
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
        $subHeadingId = $this->route('sub_heading')->id; // Assuming your route parameter is named 'subheadings'
        return [
            'sub_heading_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_headings')->ignore($subHeadingId),
            ],
        ];
    }
}
