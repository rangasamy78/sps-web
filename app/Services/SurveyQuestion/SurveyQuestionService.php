<?php
namespace App\Services\SurveyQuestion;

use App\Models\SurveyQuestion;

class SurveyQuestionService
{
    public function getTransactionTypeBasedQuestionId($id)
    {
        $count = SurveyQuestion::query()
                ->where('transaction', $id)
                ->orderBy('id', 'desc')
                ->take(1)
                ->pluck('transaction_question_id');
                
        return response()->json(['count' => $count]);   
    }
}