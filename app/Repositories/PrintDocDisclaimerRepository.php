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

    public function getPrintDocDisclaimerList()
    {
        return PrintDocDisclaimer::with(['select_type_category', 'select_type_sub_category']);
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
        $states          = $this->getPrintDocDisclaimerList();
        $total           = $states->count();
        $totalFilter     = $this->getPrintDocDisclaimerList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('title', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPrintDocDisclaimerList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('title', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                         = ++$i;
            $value->title                       = $value->title ?? '';
            $value->select_type_category_id     = $value->select_type_category->select_type_category_name ?? '';
            $value->select_type_sub_category_id = $value->select_type_sub_category->select_type_sub_category_name ?? '';
            $value->policy                      = $value->policy ?? '';
            $value->action                      = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

}
