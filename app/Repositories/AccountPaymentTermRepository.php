<?php

namespace App\Repositories;

use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\AccountPaymentTerm;
use Illuminate\Database\Eloquent\Model;
use App\Services\AccountPaymentTerm\AccountPaymentTermService;
use App\Interfaces\{ CrudRepositoryInterface, DatatableRepositoryInterface };

class AccountPaymentTermRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public $accountPaymentTermService;
 
    public function __construct(AccountPaymentTermService $accountPaymentTermService){
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
        if (!empty($request->term_search) ) {
            $query->where('payment_type', $request->term_search);
        }
        if (!empty($request->code_search)) {
            $query->where('payment_code', 'like', '%' . $request->code_search . '%');
        }
        if (!empty($request->label_search)) {
            $query->where('payment_label', 'like', '%' . $request->label_search . '%');
        }
        if (!empty($request->net_due_search)) {
            $query->where('payment_net_due_day', 'like', '%' .  $request->net_due_search  . '%');
        }
        $query->where('payment_standard_date_driven', $request->toggleBtnVal);
        return $query;
    }

    public function dataTable(Request $request)
    {
        $toggleBtnVal         =         $request->get('toggleBtnVal');
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

        $accountPaymentTerms = $this->getAccountPaymentTermList($request);
        $total = $accountPaymentTerms->count();

        $totalFilter = $this->getAccountPaymentTermList($request);
        $totalFilter = $totalFilter->count();
        
        $arrData = $this->getAccountPaymentTermList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();     

        $arrData->map(function ($value) {
            $value->payment_code = $value->payment_code ?? '';
            $value->payment_label = $value->payment_label ?? '';
            $value->payment_type =  $this->accountPaymentTermService->getAccountTypeList($value->payment_type);
            $value->payment_net_due_day = $this->accountPaymentTermService->getAccountPaymentTermLabel($value->payment_net_due_day, $value->payment_standard_date_driven) ?? '';
            $value->payment_usage = $this->accountPaymentTermService->getPaymentUsage($value->payment_not_used_sales, $value->payment_not_used_purchases) ?? '';
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