<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\AccountPaymentTerm;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Services\AccountPaymentTerm\AccountPaymentTermService;

class AccountPaymentTermRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public $accountPaymentTermService;

    public function __construct(AccountPaymentTermService $accountPaymentTermService)
    {
        $this->accountPaymentTermService = $accountPaymentTermService;
    }

    public function findOrFail(int $id)
    {
        return AccountPaymentTerm::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return AccountPaymentTerm::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        return AccountPaymentTerm::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getAccountPaymentTermList(Request $request)
    {
        $query = AccountPaymentTerm::query();
        if (!empty($request->term_search)) {
            $query->where('payment_type', $request->term_search);
        }
        if (!empty($request->code_search)) {
            $query->where('payment_code', 'like', '%' . $request->code_search . '%');
        }
        if (!empty($request->label_search)) {
            $query->where('payment_label', 'like', '%' . $request->label_search . '%');
        }
        if (!empty($request->net_due_search)) {
            $query->where('payment_net_due_day', 'like', '%' . $request->net_due_search . '%');
        }
        $query->where('payment_standard_date_driven', $request->toggleBtnVal);
        return $query;
    }

    public function dataTable(Request $request)
    {
        $toggleBtnVal    = $request->get('toggleBtnVal');
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

        $accountPaymentTerms = $this->getAccountPaymentTermList($request);
        $total               = $accountPaymentTerms->count();

        $totalFilter = $this->getAccountPaymentTermList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getAccountPaymentTermList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->payment_code        = $value->payment_code ?? '';
            $value->payment_label       = $value->payment_label ?? '';
            $value->payment_type        = $this->accountPaymentTermService->getAccountTypeList($value->payment_type);
            $value->payment_net_due_day = $this->accountPaymentTermService->getAccountPaymentTermLabel($value->payment_net_due_day, $value->payment_standard_date_driven) ?? '';
            $value->payment_usage       = $this->accountPaymentTermService->getPaymentUsage($value->payment_not_used_sales, $value->payment_not_used_purchases) ?? '';
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
