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
        1 => 'Hold',
        2 => 'Opportunity',
        3 => 'Quote',
        4 => 'Sale Order',
        5 => 'Selection Sheet',
    ];

    public static function getPredefinedSurveyQuestionOptions()
    {
        return self::$predefinedSurveyQuestionOptions;
    }

    public static function getSurveyQuestionOptions($id)
    {
        switch ($id) {
            case 1:
                return 'Hold';
            case 2:
                return 'Opportunity';
            case 3:
                return 'Quote';
            case 4:
                return 'Sale Order';
            case 5:
                return 'Selection Sheet';
        }
    }
}
