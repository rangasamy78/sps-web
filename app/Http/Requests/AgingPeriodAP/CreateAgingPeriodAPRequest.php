<?php

namespace App\Http\Requests\AgingPeriodAP;

use Illuminate\Foundation\Http\FormRequest;

class CreateAgingPeriodAPRequest extends FormRequest
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
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $ap_1_start = $this->input('ap_invoice_date_start_1');
            $ap_1_end = $this->input('ap_invoice_date_end_1');
            $ap_2_start = $this->input('ap_invoice_date_start_2');
            $ap_2_end = $this->input('ap_invoice_date_end_2');
            $ap_3_start = $this->input('ap_invoice_date_start_3');
            $ap_3_end = $this->input('ap_invoice_date_end_3');
            $ap_4_start = $this->input('ap_invoice_date_start_4');
            $ap_4_end = $this->input('ap_invoice_date_end_4');

            if($ap_1_start >= $ap_1_end){
                $validator->errors()->add('aging_period_ap_1_greater_than', 'Each period must be greater than the preceding one.');
            }else if($ap_2_start >= $ap_2_end){
                $validator->errors()->add('aging_period_ap_2_greater_than', 'Each period must be greater than the preceding one.');
            }else if($ap_3_start >= $ap_3_end){
                $validator->errors()->add('aging_period_ap_3_greater_than', 'Each period must be greater than the preceding one.');
            }else if($ap_4_start >= $ap_4_end){
                $validator->errors()->add('aging_period_ap_4_greater_than', 'Each period must be greater than the preceding one.');
            }
        });
    }
}
