<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\AboutUsOption;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class AboutUsOptionRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return AboutUsOption::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return AboutUsOption::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return AboutUsOption::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getAboutUsOptionList($request)
    {
        $query = AboutUsOption::query();
        if (!empty($request->how_did_you_hear_option_search)) {
            $query->where('how_did_you_hear_option', 'like', '%' . $request->how_did_you_hear_option_search . '%');
        }
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw                 =         $request->get('draw');
        $start                =         $request->get("start");
        $rowPerPage           =         $request->get("length");
        $orderArray           =         $request->get('order');
        $columnNameArray      =         $request->get('columns');
        $columnIndex          =         $orderArray[0]['column'];
        $columnName           =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder      =         $orderArray[0]['dir'];
        $aboutUsOptions = $this->getAboutUsOptionList($request);
        $total = $aboutUsOptions->count();
        $totalFilter = $this->getAboutUsOptionList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getAboutUsOptionList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->how_did_you_hear_option = $value->how_did_you_hear_option ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'>
            <i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'>
            <i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'>
            <i class='fas fa-trash-alt'></i></button>";
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
