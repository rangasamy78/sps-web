<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Http\Request;
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
        $query = $this->findOrFail($id)->delete();
        return $query;
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
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $countrys        = $this->getCountryList($request);
        $total           = $countrys->count();
        $totalFilter     = $this->getCountryList($request);
        $totalFilter     = $totalFilter->count();
        $arrData         = $this->getCountryList($request);
        $arrData         = $arrData->skip($start)->take($rowPerPage);
        $arrData         = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData         = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->sno          = ++$i;
            $value->country_name = $value->country_name ?? '';
            $value->action       = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
