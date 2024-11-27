<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PrePurchaseRequest;
use App\Interfaces\CrudRepositoryInterface;
use App\Models\PrePurchaseRequestInternalNote;
use App\Interfaces\DatatableRepositoryInterface;

class PrePurchaseRequestRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return PrePurchaseRequest::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return PrePurchaseRequest::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = $this->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function buildBaseQuery()
    {
        return PrePurchaseRequest::query()->with(['supplier', 'user']);
    }

    public function getPrePurchaseRequestList($request)
    {
        $query = $this->buildBaseQuery();
        if (!empty($request->transaction_number)) {
            $query->where('transaction_number', $request->transaction_number);
        }
        if (!empty($request->pre_purchase_date)) {
            $query->whereDate('pre_purchase_date', Carbon::createFromFormat('Y-m-d', $request->pre_purchase_date));
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if (!empty($request->required_ship_date)) {
            $query->whereDate('required_ship_date', Carbon::createFromFormat('Y-m-d', $request->required_ship_date));
        }
        if (!empty($request->requested_by_id)) {
            $query->where('requested_by_id', $request->requested_by_id);
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

        $columnName = 'created_at';
        $countries  = $this->getPrePurchaseRequestList($request);
        $total      = $countries->count();

        $totalFilter = $this->getPrePurchaseRequestList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPrePurchaseRequestList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                = ++$i;
            $value->transaction_number = $value->transaction_number ?? '';
            $value->pre_purchase_date  = toDbDateDisplay($value->pre_purchase_date);
            $value->supplier_name      = $this->getSupplierDetails($value->supplier);
            $value->required_ship_date = toDbDateDisplay($value->required_ship_date);
            $value->age                = $value->pre_purchase_date ?? '';
            $value->requested_by       = $this->getUserDetails($value->user);
            $value->requested          = $value->requested_by_id ?? '';
            $value->response           = $value->requested_by_id ?? '';
            $value->eta_date           = $value->eta_date ?? '';
            $value->terms              = $value->terms ? '<img src="' . url('public\assets\img\icon-image\internal_notes.png') . '" width="20" height="20" alt="Image" title="'.$value->terms.'">' : '';  ;
            $value->action             = "<div class='dropup'>
            <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i>
            </button>
            <div class='dropdown-menu'>
                <a class='dropdown-item showbtn text-warning' href='" . route('pre_purchase_requests.show', $value->id) . "'>
                    <i class='bx bx-show me-1 icon-warning'></i> Show
                </a>
                <a class='dropdown-item editbtn text-success' href='" . route('pre_purchase_requests.edit', $value->id) . "'>
                    <i class='bx bx-edit-alt me-1 icon-success'></i> Edit
                </a>
                <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "'>
                    <i class='bx bx-trash me-1 icon-danger'></i> Delete
                </a>
            </div>
        </div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function getSupplierDetails($value){

        $result = !empty($value) ? $value['supplier_name'] ." ( ". $value['code'] ." )" : '';

        return $result;
    }

    public function getUserDetails($user){

        $result = !empty($user) ? $user['full_name'] : '';

        return $result;
    }

    public function internalNoteSave(array $data)
    {
        return PrePurchaseRequestInternalNote::query()
            ->create($data);
    }

    public function getInternalNotes($id){
        $results = PrePurchaseRequestInternalNote::query()->where('pre_purchase_request_id',$id)->get();
        $output = '';
        if(!empty($results)){
            foreach($results as $result){
                $output .= '<div>' . e($result['internal_notes']) . '</div>';
            }
        }
        return $output;
    }

}
