<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SpecialInstruction;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class SpecialInstructionRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail($id)
    {
        return SpecialInstruction::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SpecialInstruction::query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        SpecialInstruction::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getSpecialInstructionList($request)
    {
        $query = SpecialInstruction::query();
        if (!empty($request->special_instruction)) {
            $query->where('special_instruction_name', 'like', '%' . $request->special_instruction . '%');
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

        $columnName          = 'created_at';
        $specialAccountTypeList = $this->getSpecialInstructionList($request);
        $total               = $specialAccountTypeList->count();

        $totalFilter = $this->getSpecialInstructionList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSpecialInstructionList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->special_instruction_name = $value->special_instruction_name ?? '';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
