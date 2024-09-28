<?php

namespace App\Repositories;

use App\Models\TaxAuthority;
use Illuminate\Http\Request;
use App\Interfaces\ { CrudRepositoryInterface, DatatableRepositoryInterface };

class TaxAuthorityRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return TaxAuthority::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return TaxAuthority::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = TaxAuthority::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getTaxAuthorityList($request)
    {
        $query = TaxAuthority::query();
        if (!empty($request->authority_name)) {
            $query->where('authority_name', 'like', '%' . $request->authority_name . '%');
        }
        if (!empty($request->authority_code)) {
            $query->where('authority_code', 'like', '%' . $request->authority_code . '%');
        }
        if (!empty($request->city)) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if (!empty($request->state)) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }
        if (!empty($request->zip)) {
            $query->where('zip', 'like', '%' . $request->zip . '%');
        }
        if (!empty($request->tax_number)) {
            $query->where('tax_number', 'like', '%' . $request->tax_number . '%');
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
        $taxAuthoritys = $this->getTaxAuthorityList($request);
        $total         = $taxAuthoritys->count();

        $totalFilter = $this->getTaxAuthorityList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getTaxAuthorityList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno            = ++$i;
            $value->authority_name = $value->authority_name ?? '';
            $value->authority_code = $value->authority_code ?? '';
            $value->city           = $value->city ?? '';
            $value->state          = $value->state ?? '';
            $value->zip            = $value->zip ?? '';
            $value->tax_number     = $value->tax_number ?? '';
            $value->action                = "<div class='dropup'>
                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                    <i class='bx bx-dots-vertical-rounded icon-color'></i>
                </button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item showbtn text-warning' href='" . route('tax_authorities.show', $value->id) . "'>
                        <i class='bx bx-show me-1 icon-warning'></i> Show
                    </a>
                    <a class='dropdown-item editbtn text-success' href='" . route('tax_authorities.edit', $value->id) . "'>
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
}
