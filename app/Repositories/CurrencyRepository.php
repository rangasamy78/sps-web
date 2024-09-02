<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class CurrencyRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id): Model
    {
        return Currency::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Currency::query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        Currency::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getCurrenciesList($request)
    {
        $query = Currency::query();
        if (!empty($request->currency_code_search) ) {
            $query->where('currency_code', 'like', '%' . $request->currency_code_search . '%');
        }
        if (!empty($request->currency_name_search) ) {
            $query->where('currency_name', 'like', '%' . $request->currency_name_search . '%');
        }
        if (!empty($request->currency_symbal_search) ) {
            $query->where('currency_symbol', $request->currency_symbal_search);
        }
        if (!empty($request->currency_exchange_rate_search) ) {
            $query->where('currency_exchange_rate', 'like', '%' . $request->currency_exchange_rate_search . '%');
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

        $columnName   = 'created_at';
        $Currencies   = $this->getCurrenciesList($request);
        $total        = $Currencies->count();

        $totalFilter = $this->getCurrenciesList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getCurrenciesList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData     = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->slno                   = ++$i;
            $value->currency_code          = $value->currency_code ?? '';
            $value->currency_name          = $value->currency_name ?? '';
            $value->currency_symbol        = $value->currency_symbol ?? '';
            $value->currency_exchange_rate = $value->currency_exchange_rate ?? 0;
            $value->formatted_date         = $value->updated_at ? Carbon::parse($value->updated_at)->timezone('Asia/Kolkata')->format('d/m/Y H:i') : 'N/A';
            $value->action                 = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
