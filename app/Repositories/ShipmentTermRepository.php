<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\ShipmentTerm;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ShipmentTermRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return ShipmentTerm::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return ShipmentTerm::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = ShipmentTerm::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getShipmentTermList($request)
    {
        $query = ShipmentTerm::query();
        if (!empty($request->shipment_terms_search)) {
            $query->where('shipment_term_name', 'like', '%' . $request->shipment_terms_search . '%');
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
        $shipmentTerms   = $this->getShipmentTermList($request);
        $total           = $shipmentTerms->count();

        $totalFilter     = $this->getShipmentTermList($request);
        $totalFilter     = $totalFilter->count();

        $arrData         = $this->getShipmentTermList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
        
        $arrData->map(function ($value) {
            $value->shipment_term_name = $value->shipment_term_name ?? '';
            $value->description        = $value->description ?? ''; // Default to empty string if null
            if (strlen($value->description) > 150) {
                $value->description = substr($value->description, 0, 150) . '...';
            }
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' ><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
