<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\SupplierPort;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class CountryRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return Country::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Country::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = $this->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $subCategories = SupplierPort::where('country_id', $id)->first();
        if ($subCategories) {
            return response()->json(['status' => 'error', 'msg' => 'Country cannot be deleted because it has Supplier Port.'], 200);
        } else {
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Country deleted successfully.'], 200);
        }
    }
    public function getCountryList($request)
    {
        $query = Country::query();
        if (!empty($request->country_name_search)) {
            $query->where('country_name', 'like', '%' . $request->country_name_search . '%');
        }
        if (!empty($request->country_code_search)) {
            $query->where('country_code', 'like', '%' . $request->country_code_search . '%');
        }
        if (!empty($request->lead_time_search)) {
            $query->where('lead_time', 'like', '%' . $request->lead_time_search . '%');
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

        $columnName      = 'created_at';
        $countries       = $this->getCountryList($request);
        $total           = $countries->count();

        $totalFilter     = $this->getCountryList($request);
        $totalFilter     = $totalFilter->count();

        $arrData         = $this->getCountryList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno          = ++$i;
            $value->country_name = $value->country_name ?? '';
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
