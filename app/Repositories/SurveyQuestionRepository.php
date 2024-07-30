<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Services\SurveyQuestion\SurveyQuestionService;

class SurveyQuestionRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public $surveyQuestionService;
 
    public function __construct(SurveyQuestionService $surveyQuestionService){
        $this->surveyQuestionService = $surveyQuestionService;
    }

    public function findOrFail(int $id)
    {
        return SurveyQuestion::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SurveyQuestion::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SurveyQuestion::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getSurveyQuestionsList()
    {
        $query = SurveyQuestion::query();
        return $query;
    }
    
    public function dataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue = $searchArray['value'];
        $surveyQuestions = $this->getSurveyQuestionsList();
        $total = $surveyQuestions->count();
        $totalFilter = $this->getSurveyQuestionsList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('transaction', 'like', '%' . $searchValue . '%')
                ->orWhere('short_label', 'like', '%' . $searchValue . '%')
                ->orWhere('question', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getSurveyQuestionsList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('transaction', 'like', '%' . $searchValue . '%')
                ->orWhere('short_label', 'like', '%' . $searchValue . '%')
                ->orWhere('question', 'like', '%' . $searchValue . '%');

        }
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->transaction = SurveyQuestion::getSurveyQuestionOptions($value->transaction);
            $value->short_label = $value->short_label ?? '';
            $value->question = $value->question ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
        });
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );
        return response()->json($response);
    }

    public function transactionTypeBasedQuestion($id)
    {
        return $this->surveyQuestionService->getTransactionTypeBasedQuestionId($id);     
    }
}
