<?php

namespace App\Repositories;

use App\Models\SupplierPort;
use Illuminate\Http\Request;
use App\Interfaces\{ CrudRepositoryInterface, DatatableRepositoryInterface, DropDownRepositoryInterface };
use App\Services\Country\CountryService;

class SupplierPortRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

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

    public function getSupplierPortList()
    {
        $query = SupplierPort::query();
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

        $supplierPort = $this->getSupplierPortList();
        $total = $supplierPort->count();

        $totalFilter = $this->getSupplierPortList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('supplier_port_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSupplierPortList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('supplier_port_name', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->supplier_port_name = $value->supplier_port_name ?? '';
            $value->avg_days = $value->avg_days ?? '';
            $value->country_id = $this->countryService->getCountryNameById($value->country_id) ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
