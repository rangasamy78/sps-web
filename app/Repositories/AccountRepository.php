<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Account::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        // if (!isset($data['form_1099_printed'])) {
        //     $data['form_1099_printed'] = 0;
        // }
        // if (!isset($data['multi_location_Account'])) {
        //     $data['multi_location_Account'] = 0;
        // }
        return Account::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        // if (!isset($data['form_1099_printed'])) {
        //     $data['form_1099_printed'] = 0;
        // }
        // if (!isset($data['multi_location_Account'])) {
        //     $data['multi_location_Account'] = 0;
        // }
        $query = Account::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getAccountList($request)
    {
        $query = Account::with(['Account_type', 'currency', 'location', 'language', 'payment_term', 'Account_port']);
        if (!empty($request->Account_name_search)) {
            $query->where('Account_name', 'like', '%' . $request->Account_name_search . '%');
        }
        if (!empty($request->currency_search)) {
            $query->whereIn('currency_id', (array) $request->currency_search);
        }
        if (!empty($request->Account_type_search)) {
            $query->whereIn('Account_type_id', (array) $request->Account_type_search);
        }
        if (!empty($request->address_search)) {
            $query->where('remit_address', 'like', '%' . $request->address_search . '%');
        }
        if (!empty($request->phone_search)) {
            $query->where('mobile', $request->phone_search);
        }
        if (!empty($request->location_search)) {
            $query->whereIn('parent_location_id', (array) $request->location_search);
        }
        if (!empty($request->payment_term_search)) {
            $query->whereIn('payment_terms_id', (array) $request->payment_term_search);
        }
        if (!empty($request->language_search)) {
            $query->whereIn('language_id', (array) $request->language_search);
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
        $Account   = $this->getAccountList($request);
        $total      = $Account->count();

        $totalFilter = $this->getAccountList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getAccountList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->Account_name = "<a href='" . route('Accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->Account_name ?? '') . "</a>";
            $value->currency_id        = $value->currency ? $value->currency->currency_name : '';
            $value->Account_type_id   = $value->Account_type ? $value->Account_type->Account_type_name : '';
            $value->remit_address      = $value->remit_address ?? '';
            $value->mobile             = $value->mobile ?? '';
            $value->parent_location_id = $value->location ? $value->location->company_name : '';
            $value->payment_terms_id   = $value->payment_term ? $value->payment_term->payment_label : '';
            $value->language_id        = $value->language ? $value->language->language_name : '';
            $value->combined_notes = "<div class='d-flex align-items-center'>" . (!empty($value->shipping_instruction) ? "<span class='avatar-initial rounded bg-label-secondary me-2' data-bs-toggle='tooltip' data-bs-placement='top'    title='" . htmlspecialchars($value->shipping_instruction ? $value->shipping_instruction : 'Shipping Instruction', ENT_QUOTES, 'UTF-8') . "'><i class='bx bx-package bx-sm'></i></span>" : '') . "" . (!empty($value->internal_notes) ? "<span class='avatar-initial rounded bg-label-secondary me-2' data-bs-toggle='tooltip' data-bs-placement='top'   title='" . htmlspecialchars($value->internal_notes ? $value->internal_notes : 'Internal Notes', ENT_QUOTES, 'UTF-8') . "'><i class='bx bx-note bx-sm'></i></span>" : '') . "</div>";
            $value->status = $value->status === 0 ? 'Inactive' : 'Active';
            $value->action             = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success'  href='" . route('Accounts.edit', $value->id) . "' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a></div> </div>";
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
