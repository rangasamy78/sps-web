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

    public function __construct(SurveyQuestionService $surveyQuestionService)
    {
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
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue     = $searchArray['value'];
        $surveyQuestions = $this->getSurveyQuestionsList();
        $total           = $surveyQuestions->count();
        $totalFilter     = $this->getSurveyQuestionsList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('transaction', 'like', '%' . $searchValue . '%')
                ->orWhere('short_label', 'like', '%' . $searchValue . '%')
                ->orWhere('question', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getSurveyQuestionsList();
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('transaction', 'like', '%' . $searchValue . '%')
                ->orWhere('short_label', 'like', '%' . $searchValue . '%')
                ->orWhere('question', 'like', '%' . $searchValue . '%');

        }
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->transaction = SurveyQuestion::getSurveyQuestionOptions($value->transaction);
            $value->short_label = $value->short_label ?? '';
            $value->question    = $value->question ?? '';
            $value->action      = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function transactionTypeBasedQuestion($id)
    {
        return $this->surveyQuestionService->getTransactionTypeBasedQuestionId($id);
    }
}
