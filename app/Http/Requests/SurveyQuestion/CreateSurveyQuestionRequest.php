<?php

namespace App\Http\Requests\SurveyQuestion;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSurveyQuestionRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'transaction' => [
                'required',
                Rule::unique('survey_questions')->where(function ($query) {
                    return $query->where('transaction', $this->input('transaction'))
                        ->where('short_label', $this->input('short_label'))
                        ->where('question', $this->input('question'));
                        
                })->ignore($this->route('survey_question')),
            ],
            'short_label' => [
                'required',
                Rule::unique('survey_questions')->where(function ($query) {
                    return $query->where('transaction', $this->input('transaction'))
                        ->where('short_label', $this->input('short_label'))
                        ->where('question', $this->input('question'))
                        ->where('transaction_question_id', $this->input('transaction_question_id'));
                })->ignore($this->route('survey_question')),
            ],
            'question' => [
                'required',
                Rule::unique('survey_questions')->where(function ($query) {
                    return $query->where('transaction', $this->input('transaction'))
                        ->where('short_label', $this->input('short_label'))
                        ->where('question', $this->input('question'))
                        ->where('transaction_question_id', $this->input('transaction_question_id'));
                })->ignore($this->route('survey_question')),
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
            'transaction.unique' => 'The combination of Survey Question Short Label and|or Question has already been taken for the same Transaction.',
            'short_label.unique' => 'The combination of Survey Question Short Label and|or Question has already been taken for the same Transaction.',
            'question.unique' => 'The combination of Survey Question Short Label and|or Question has already been taken for the same Transaction.',
        ];
    }
}
