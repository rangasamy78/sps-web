<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class PaymentMethodRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id): Model
    {
        return PaymentMethod::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        if (!isset($data['is_transaction_required'])) {
            $data['is_transaction_required'] = 0;
        }
        return PaymentMethod::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        if (!isset($data['is_transaction_required'])) {
            $data['is_transaction_required'] = 0;
        }
        return PaymentMethod::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getPaymentMethodList()
    {
        $query = PaymentMethod::with('linked_account', 'account_type');
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw                 =         $request->get('draw');
        $start                =         $request->get("start");
        $rowPerPage           =         $request->get("length");
        $orderArray           =         $request->get('order');
        $columnNameArray      =         $request->get('columns');
        $searchArray          =         $request->get('search');
        $columnIndex          =         $orderArray[0]['column'];
        $columnName           =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder      =         $orderArray[0]['dir'];
        $searchValue          =         $searchArray['value'];
        $PaymentMethod = $this->getPaymentMethodList();
        $total = $PaymentMethod->count();

        $totalFilter = $this->getPaymentMethodList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('payment_method_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getPaymentMethodList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('payment_method_name', 'like', '%' . $searchValue . '%')
                ->orwhere('linked_account_id', 'like', '%' . $searchValue . '%')
                ->orwhere('account_type_id', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->payment_method_name = $value->payment_method_name ?? '';
            $value->linked_account_id = $value->linked_account_details ?? '';
            $value->account_type_id = $value->account_type ? $value->account_type->account_type_name : '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
