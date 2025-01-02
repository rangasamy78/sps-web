<?php

namespace App\Repositories;

use App\Models\QuoteHeader;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class QuoteHeaderRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return QuoteHeader::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return QuoteHeader::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return QuoteHeader::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getQuoteHeaderList($request)
    {
        $query = QuoteHeader::query();
        if (!empty($request->quote_header_name_search)) {
            $query->where('quote_header_name', 'like', '%' . $request->quote_header_name_search . '%');
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
        $aboutUsOptions = $this->getQuoteHeaderList($request);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getQuoteHeaderList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getQuoteHeaderList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->quote_header_name = $value->quote_header_name ?? '';
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
