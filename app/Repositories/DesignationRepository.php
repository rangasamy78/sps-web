<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class DesignationRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return Designation::query()
            ->findOrFail($id);
    }

    public function store(array $data): array
    {
        $designations = [];
        $fieldCount   = count($data['designation_name_']);

        for ($i = 0; $i < $fieldCount; $i++) {
            if (isset($data['designation_name_'][$i]) && isset($data['department_id_'][$i])) {
                $designations[] = Designation::create([
                    'department_id'    => $data['department_id_'][$i],
                    'designation_name' => $data['designation_name_'][$i],
                ]);
            }
        }

        return $designations;
    }

    public function update(array $data, int $id): void
    {
        // Map the input data
        $mappedData = [
            'department_id'    => $data['department_id'] ?? null,
            'designation_name' => $data['designation_name'] ?? null,
        ];

        // Find the record and update it
        $designation = Designation::findOrFail($id);
        $designation->update($mappedData);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getDesignationsList()
    {
        $query = Designation::query();
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

        $designation = $this->getDesignationsList();
        $total       = $designation->count();

        $totalFilter = $this->getDesignationsList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('designation_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getDesignationsList();
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('designation_name', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->designation_name = $value->designation_name ?? '';
            $value->department_id    = Department::getDepartmentList($value->department_id);
            $value->action           = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
