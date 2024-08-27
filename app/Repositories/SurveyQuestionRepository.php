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

    public function getSurveyQuestionsList($request)
    {
        $query = SurveyQuestion::query();
        if (!empty($request->transaction_search) ) {
            $query->where('transaction', $request->transaction_search);
        }
        if (!empty($request->short_label_search) ) {
            $query->where('short_label', 'like', '%' . $request->short_label_search . '%');
        }
        if (!empty($request->question_search) ) {
            $query->where('question', 'like', '%' . $request->question_search . '%');
        }
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $surveyQuestions = $this->getSurveyQuestionsList($request);
        $total           = $surveyQuestions->count();

        $totalFilter     = $this->getSurveyQuestionsList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getSurveyQuestionsList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->transaction = SurveyQuestion::getSurveyQuestionOptions($value->transaction);
            $value->short_label = $value->short_label ?? '';
            $value->question    = $value->question ?? '';
            $value->action      = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
