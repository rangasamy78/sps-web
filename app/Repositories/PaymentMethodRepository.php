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
        $PaymentMethod   = $this->getPaymentMethodList();
        $total           = $PaymentMethod->count();

        $totalFilter = $this->getPaymentMethodList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('payment_method_name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getPaymentMethodList();
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('payment_method_name', 'like', '%' . $searchValue . '%')
                ->orwhere('linked_account_id', 'like', '%' . $searchValue . '%')
                ->orwhere('account_type_id', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->payment_method_name = $value->payment_method_name ?? '';
            $value->linked_account_id   = $value->linked_account_details ?? '';
            $value->account_type_id     = $value->account_type ? $value->account_type->account_type_name : '';
            $value->action              = "<div class='dropdown'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
