<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ServiceTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return ServiceType::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return ServiceType::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return ServiceType::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getServiceTypeList($request)
    {
        $query = ServiceType::query();
        if (!empty($request->service_type_search)) {
            $query->where('service_type', 'like', '%' . $request->service_type_search . '%');
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

        $columnName     = 'created_at';
        $serviceTypes = $this->getServiceTypeList($request);
        $total          = $serviceTypes->count();

        $totalFilter = $this->getServiceTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getServiceTypeList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->service_type = $value->service_type ?? '';
            $value->action                  = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
            return $value;
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
