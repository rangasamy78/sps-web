<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class AccountRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Account::with('account_type', 'currency', 'company')
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        if (!isset($data['is_allow_printing_checks'])) {
            $data['is_allow_printing_checks'] = 0;
        }
        if (!isset($data['is_default_account'])) {
            $data['is_default_account'] = 0;
        }
        if (!isset($data['is_budgeted_account'])) {
            $data['is_budgeted_account'] = 0;
        }
        if (!isset($data['is_tax_account'])) {
            $data['is_tax_account'] = 0;
        }
        if (!isset($data['is_reconciled_account'])) {
            $data['is_reconciled_account'] = 0;
        }
        if (!isset($data['is_allow_bank_reconciliation'])) {
            $data['is_allow_bank_reconciliation'] = 0;
        }
        return Account::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        if (!isset($data['is_allow_printing_checks'])) {
            $data['is_allow_printing_checks'] = 0;
        }
        if (!isset($data['is_default_account'])) {
            $data['is_default_account'] = 0;
        }
        if (!isset($data['is_budgeted_account'])) {
            $data['is_budgeted_account'] = 0;
        }
        if (!isset($data['is_tax_account'])) {
            $data['is_tax_account'] = 0;
        }
        if (!isset($data['is_reconciled_account'])) {
            $data['is_reconciled_account'] = 0;
        }
        if (!isset($data['is_allow_bank_reconciliation'])) {
            $data['is_allow_bank_reconciliation'] = 0;
        }
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
        $query = Account::with(['account_type', 'account_sub_type', 'special_account_type']);
        if (!empty($request->account_number_search)) {
            $query->where('account_number', 'like', '%' . $request->account_number_search . '%');
        }
        if (!empty($request->account_name_search)) {
            $query->where('account_name', 'like', '%' . $request->account_name_search . '%');
        }
        if (!empty($request->alternate_number_search)) {
            $query->where('alternate_number', 'like', '%' . $request->alternate_number_search . '%');
        }
        if (!empty($request->alternate_name_search)) {
            $query->where('alternate_name', 'like', '%' . $request->alternate_name_search . '%');
        }
        if (!empty($request->account_type_search)) {
            $query->whereIn('account_type_id', (array)$request->account_type_search);
        }
        if (!empty($request->sub_account_type_search)) {
            $query->whereIn('account_sub_type_id', (array)$request->sub_account_type_search);
        }
        if (!empty($request->special_account_type_search)) {
            $query->whereIn('special_account_type_id', (array)$request->special_account_type_search);
        }
        if (!empty($request->sub_account_of_search)) {
            $query->whereIn('is_sub_account_of_id', (array)$request->sub_account_of_search);
        }
        if (isset($request->status_search)) {
            if (is_array($request->status_search)) {
                $query->whereIn('status', $request->status_search);
            } else {
                $query->where('status', $request->status_search);
            }
        }
        return $query;
    }
    public function getInAccountList($request)
    {
        $query = Account::query();
        $query->where('status', 0);
        return $query;
    }

    public function getIsSubAccount($id)
    {
        $account = Account::find($id);
        return $account && $account->account_name ? $account->account_name : 'N/A';
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
            $value->account_number = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_number ?? '') . "</a>";
            $value->account_name        = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_name ?? '') . "</a>";
            $value->alternate_number   = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->alternate_number ?? '') . "</a>";
            $value->alternate_name      = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->alternate_name ?? '') . "</a>";
            $value->account_type_id      = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_type ? $value->account_type->account_type_name : '') . "</a>";
            $value->account_sub_type_id = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_sub_type ? $value->account_sub_type->sub_type_name : '') . "</a>";
            $value->special_account_type_id   =  "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->special_account_type ? $value->special_account_type->special_account_type_name  : '') . "</a>";
            $value->is_sub_account_of_id = $this->getIsSubAccount($value->is_sub_account_of_id);
            $value->balance        = 0;
            $value->status = $value->status === 0 ? 'Inactive' : 'Active';
            $value->action             = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success'  href='" . route('accounts.edit', $value->id) . "' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a></div> </div>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function inAccountDataTable(Request $request)
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
        $Account   = $this->getInAccountList($request);
        $total      = $Account->count();

        $totalFilter = $this->getInAccountList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getInAccountList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->account_number = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_number ?? '') . "</a>";
            $value->account_name        = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_name ?? '') . "</a>";
            $value->alternate_number   = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->alternate_number ?? '') . "</a>";
            $value->alternate_name      = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->alternate_name ?? '') . "</a>";
            $value->account_type_id      = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_type ? $value->account_type->account_type_name : '') . "</a>";
            $value->account_sub_type_id = "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->account_sub_type ? $value->account_sub_type->sub_type_name : '') . "</a>";
            $value->special_account_type_id   =  "<a href='" . route('accounts.show', $value->id) . "' class='text-secondary    '>" . ($value->special_account_type ? $value->special_account_type->special_account_type_name  : '') . "</a>";
            $value->is_sub_account_of_id = $this->getIsSubAccount($value->is_sub_account_of_id);
            $value->balance        = 0;
            $value->status = $value->status === 0 ? 'Inactive' : 'Active';
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
