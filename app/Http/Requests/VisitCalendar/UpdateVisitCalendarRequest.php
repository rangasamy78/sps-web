<?php
namespace App\Http\Requests\VisitCalendar;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitCalendarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
