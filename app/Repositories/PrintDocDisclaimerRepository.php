<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\PrintDocDisclaimer;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Services\PrintDocDisclaimer\PrintDocDisclaimerService;

class PrintDocDisclaimerRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public $printDocDisclaimerService;
    public function __construct(PrintDocDisclaimerService $printDocDisclaimerService)
    {
        $this->printDocDisclaimerService = $printDocDisclaimerService;
    }

    public function findOrFail(int $id)
    {
        return PrintDocDisclaimer::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return PrintDocDisclaimer::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = PrintDocDisclaimer::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getPrintDocDisclaimerList($request)
    {
        $query = PrintDocDisclaimer::with(['select_type_category', 'select_type_sub_category']);
        if (!empty($request->title_search) ) {
            $query->where('title', 'like', '%' . $request->title_search. '%');
        }
        if (!empty($request->select_type_category_search) ) {
            $query->where('select_type_category_id', $request->select_type_category_search );
        }
        if (!empty($request->select_type_sub_category_search) ) {
            $query->where('select_type_sub_category_id', $request->select_type_sub_category_search);
        }
        if (!empty($request->policy_search) ) {
            $query->where('policy', 'like', '%' . $request->policy_search. '%');
        }
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
        $states = $this->getPrintDocDisclaimerList($request);
        $total = $states->count();
        $totalFilter = $this->getPrintDocDisclaimerList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPrintDocDisclaimerList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->title = $value->title ?? '';
            $value->select_type_category_id = $value->select_type_category->select_type_category_name ?? ''; 
            $value->select_type_sub_category_id = $value->select_type_sub_category->select_type_sub_category_name ?? '';
            $value->policy = $value->policy ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' >
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit'
             class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;
             <button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
        });

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

   
}
