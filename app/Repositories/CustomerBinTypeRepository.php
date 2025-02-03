<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\CustomerBinType;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class CustomerBinTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return CustomerBinType::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return CustomerBinType::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = CustomerBinType::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getCustomerBinTypeList($request)
    {
        $query = CustomerBinType::query()->with('bin_type');
        if (!empty($request->label_search)) {
            $query->where('label', 'like', '%' . $request->label_search . '%');
        }
        if (!empty($request->length_search)) {
            $query->where('length', 'like', '%' . $request->length_search . '%');
        }
        if (!empty($request->width_search)) {
            $query->where('width', 'like', '%' . $request->width_search . '%');
        }
        if (!empty($request->height_search)) {
            $query->where('height', 'like', '%' . $request->height_search . '%');
        }
        if (!empty($request->bin_type_id_search)) {
            $query->where('bin_type_id',  $request->bin_type_id_search );
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

        $columnName    = 'created_at';
        $supplierTypes = $this->getCustomerBinTypeList($request);
        $total         = $supplierTypes->count();

        $totalFilter = $this->getCustomerBinTypeList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getCustomerBinTypeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno         = ++$i;
            $value->label       = $value->label ?? '';
            $value->customer_id = $value->customer_id ?? '';
            $value->type        = $value->type ?? '';
            $value->x           = $value->x ?? '';
            $value->y           = $value->y ?? '';
            $value->z           = $value->z ?? '';
            $value->length      = $value->length ?? '';
            $value->width       = $value->width ?? '';
            $value->height      = $value->height ?? '';
            $value->zone        = $value->zone ?? '';
            $value->bin_type_id = $value->bin_type->bin_type ?? '';
            $value->action      = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showBinTypebtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editBinTypebtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deleteBinTypebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
