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

    public function getAboutUsOptionList()
    {
        $query = AboutUsOption::query();
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

        $aboutUsOptions = $this->getAboutUsOptionList();
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getAboutUsOptionList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('how_did_you_hear_option', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getAboutUsOptionList();
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('how_did_you_hear_option', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->how_did_you_hear_option = $value->how_did_you_hear_option ?? '';
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
