<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyQuestion extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_questions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction',
        'short_label',
        'question',
        'transaction_question_id',
    ];

    protected static $predefinedSurveyQuestionOptions = [
        0 => 'Hold',
        1 => 'Opportunity',
        2 => 'Quote',
        3 => 'SaleOrder',
        4 => 'Selection Sheet',
    ];

    public static function getPredefinedSurveyQuestionOptions()
    {
        return self::$predefinedSurveyQuestionOptions;
    }

    public static function getSurveyQuestionOptions($id)
    {
        switch ($id) {
            case 0:
                return 'Hold';
            case 1:
                return 'Opportunity';
            case 2:
                return 'Quote';
            case 3:
                return 'SaleOrder';
            case 4:
                return 'Selection Sheet';
        }
    }
}
