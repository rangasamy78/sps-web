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

    public function getCurrenciesList()
    {
        $query = Currency::query();
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw                   =         $request->get('draw');
        $start                  =         $request->get("start");
        $rowPerPage             =         $request->get("length");
        $orderArray             =         $request->get('order');
        $columnNameArray        =         $request->get('columns');
        $searchArray            =         $request->get('search');
        $columnIndex            =         $orderArray[0]['column'];
        $columnName             =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder        =         $orderArray[0]['dir'];
        $searchValue            =         $searchArray['value'];

        $bin = $this->getCurrenciesList();
        $total = $bin->count();

        $totalFilter = $this->getCurrenciesList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('currency_code', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getCurrenciesList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('currency_name', 'like', '%' . $searchValue . '%')
                ->orwhere('currency_code', 'like', '%' . $searchValue . '%')
                ->orwhere('currency_exchange_rate', 'like', '%' . $searchValue . '%')
                ->orwhere('currency_symbol', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->slno = ++$i;
            $value->currency_code = $value->currency_code ?? '';
            $value->currency_name = $value->currency_name ?? '';
            $value->currency_symbol = $value->currency_symbol ?? '';
            $value->currency_exchange_rate = $value->currency_exchange_rate ?? 0;
            $value->formatted_date = $value->updated_at ? Carbon::parse($value->updated_at)->timezone('Asia/Kolkata')->format('d/m/Y H:i') : 'N/A';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn' data-bs-toggle='modal' data-bs-target='#show_state-modal'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
