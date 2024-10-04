<?php

namespace App\Repositories;

use App\Models\TaxComponent;
use Illuminate\Http\Request;
use App\Interfaces\ { CrudRepositoryInterface, DatatableRepositoryInterface };

class TaxComponentRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return TaxComponent::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return TaxComponent::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = TaxComponent::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getTaxComponentList($request)
    {
        $query = TaxComponent::query()
            ->with(['tax_authority','sales_tax_account']);
        if (!empty($request->component_name)) {
            $query->where('component_name', 'like', '%' . $request->component_name . '%');
        }
        if (!empty($request->authority_id)) {
            $query->where('authority_id', $request->authority_id);
        }
        if (!empty($request->sales_tax_id)) {
            $query->where('sales_tax_id', $request->sales_tax_id);
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
        $taxAuthoritys = $this->getTaxComponentList($request);
        $total         = $taxAuthoritys->count();

        $totalFilter = $this->getTaxComponentList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getTaxComponentList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno            = ++$i;
            $value->sort_order     = $value->sort_order ?? '';
            $value->component_name = $value->component_name ?? '';
            $value->company_tax_id = $value->company_tax_id ?? '';
            $value->authority_name = $value->tax_authority ? $value->tax_authority->authority_name : '';
            $value->sales_tax_name = $value->sales_tax_account->account_number.'-'. $value->sales_tax_account->account_name ?? '';
            $value->action         = "<div class='dropup'>
                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                    <i class='bx bx-dots-vertical-rounded icon-color'></i>
                </button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item showbtn text-warning' href='" . route('tax_components.show', $value->id) . "'>
                        <i class='bx bx-show me-1 icon-warning'></i> Show
                    </a>
                    <a class='dropdown-item editbtn text-success' href='" . route('tax_components.edit', $value->id) . "'>
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
