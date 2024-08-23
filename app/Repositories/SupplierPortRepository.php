<?php

namespace App\Repositories;

use App\Models\SupplierPort;
use Illuminate\Http\Request;
use App\Interfaces\{ CrudRepositoryInterface, DatatableRepositoryInterface };
class SupplierPortRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return SupplierPort::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SupplierPort::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SupplierPort::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSupplierPortList($request)
    {
        $query = SupplierPort::query()->with('country');
        if (!empty($request->supplier_port_name_search)) {
            $query->where('supplier_port_name', 'like', '%' . $request->supplier_port_name_search . '%');
        }
        if (!empty($request->avg_days_search)) {
            $query->where('avg_days', 'like', '%' . $request->avg_days_search . '%');
        }
        if (!empty($request->country_name_search)) {
            $query->whereHas('country', function ($q) use ($request) {
                $q->where('id', $request->country_name_search);
            });
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
        $supplierPort    = $this->getSupplierPortList($request);
        $total           = $supplierPort->count();
        $totalFilter     = $this->getSupplierPortList($request);
        $totalFilter     = $totalFilter->count();
        $arrData         = $this->getSupplierPortList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno                = ++$i;
            $value->supplier_port_name = $value->supplier_port_name ?? '';
            $value->avg_days           = $value->avg_days ?? '';
            $value->country_name       = $value->country ? $value->country->country_name : '';
            $value->action             = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
