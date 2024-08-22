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
            return response()->json(['status' => 'success', 'msg' => 'Survey question saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Survey question: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Survey question.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Survey question updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Survey question: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Survey question.']);
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
            $surveyQuestion = $this->surveyQuestionRepository->findOrFail($id);
            if ($surveyQuestion) {
                $this->surveyQuestionRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Survey question deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Survey question not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Survey question: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Survey question.']);
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
