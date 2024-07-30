<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\Log;
use App\Repositories\SurveyQuestionRepository;
use App\Http\Requests\SurveyQuestion\{CreateSurveyQuestionRequest, UpdateSurveyQuestionRequest};


class SurveyQuestionController extends Controller
{
    private SurveyQuestionRepository $surveyQuestionRepository;

    public function __construct(SurveyQuestionRepository $surveyQuestionRepository)
    {
        $this->surveyQuestionRepository = $surveyQuestionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveyQuestionOptions = SurveyQuestion::getPredefinedSurveyQuestionOptions();
        return view('survey_question.survey_questions', compact('surveyQuestionOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSurveyQuestionRequest $request)
    {
        try {
            $this->surveyQuestionRepository->store($request->only('transaction', 'short_label', 'question','transaction_question_id'));
            return response()->json(['status' => 'success', 'msg' => 'Survey Question saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Survey Question: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Survey Question.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->surveyQuestionRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->surveyQuestionRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyQuestionRequest $request, SurveyQuestion $surveyQuestion)
    {
        try {
            $this->surveyQuestionRepository->update($request->only('transaction', 'short_label', 'question','transaction_question_id'), $surveyQuestion->id);
            return response()->json(['status' => 'success', 'msg' => 'Survey Question updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Survey Question: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Survey Question.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->surveyQuestionRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Survey Question deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Survey Question: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Survey Question.']);
        }
    }

    public function getSurveyQuestionDataTableList(Request $request)
    {
        return $this->surveyQuestionRepository->dataTable($request);
    }

    public function getTransactionTypeBasedQuestion(Request $request)
    {
        return $this->surveyQuestionRepository->transactionTypeBasedQuestion($request->id);
    }
}
