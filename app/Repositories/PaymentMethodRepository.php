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

    public function getPaymentMethodList($request)
    {
        $query = PaymentMethod::with('linked_account', 'account_type');
        if (!empty($request->method_name_search)) {
            $query->where('payment_method_name', 'like', '%' . $request->method_name_search . '%');
        }
        if (!empty($request->account_search)) {
            $query->whereIn('linked_account_id', $request->account_search);
        }
        if (!empty($request->account_type_search)) {
            $query->whereIn('account_type_id', $request->account_type_search);
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

        $columnName    = 'created_at';
        $PaymentMethod = $this->getPaymentMethodList($request);
        $total         = $PaymentMethod->count();

        $totalFilter = $this->getPaymentMethodList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPaymentMethodList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->payment_method_name = $value->payment_method_name ?? '';
            $value->linked_account_id   =  $value->linked_account->account_number. '-' .$value->linked_account->account_name;
            $value->account_type_id     = $value->account_type ? $value->account_type->account_type_name : '';
            $value->action              = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
