<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\TermType;
use Illuminate\Http\Request;

class TermTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return TermType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return TermType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = TermType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'msg' => 'Account type deleted successfully.'], 200);
    }

    public function getTermTypeList($request)
    {
        $query = TermType::query();
        if (!empty($request->term_type_name_search)) {
            $query->where('term_type_name', 'like', '%' . $request->term_type_name_search . '%');
        }
        if (!empty($request->type_id_search)) {
            $query->where('type_id', $request->type_id_search);
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
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName   = 'created_at';
        $accountTypes = $this->getTermTypeList($request);
        $total        = $accountTypes->count();

        $totalFilter = $this->getTermTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getTermTypeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno            = ++$i;
            $value->term_type_name = $value->term_type_name ?? '';
            $value->type_id        = $value->type_id        = 1 ? 'Standard' : 'Date driven';
            $value->action         = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
