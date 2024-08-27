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
