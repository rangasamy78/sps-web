<?php

namespace App\Repositories;

use App\Models\TaxCode;
use App\Models\TaxComponent;
use Illuminate\Http\Request;
use App\Models\TaxCodeComponent;
use App\Services\TaxCode\TaxCodeService;
use App\Interfaces\ { CrudRepositoryInterface, DatatableRepositoryInterface };

class TaxCodeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public TaxCodeService $taxCodeService;

    public function __construct(TaxCodeService $taxCodeService)
    {
        $this->taxCodeService    = $taxCodeService;
    }

    public function findOrFail(int $id)
    {
        return TaxCode::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $taxCode = TaxCode::query()->create([
            'sort_order' => $data['sort_order'],
            'tax_code' => $data['tax_code'],
            'tax_code_label' => $data['tax_code_label'],
            'notes' => $data['notes'],
            'effective_date' => date('Y-m-d', strtotime($data['effective_date'])),
        ]);

        $taxIds = $data['tax_id'];
        $taxComponent = $data['tax_component_id'];
        $taxRate = $data['tax_rate'];
        $glAccountName = $data['gl_account_name'];

        if (isset($taxComponent) && !empty($taxComponent)) {
            foreach ($taxComponent as $index => $taxComp) {
                TaxCodeComponent::create([
                    'tax_code_id' => $taxCode->id,
                    'tax_component_id' => $taxComp,
                    'rate' => $taxRate[$index],
                    'gl_account_name' => $glAccountName[$index],
                ]);
            }
        }

        if (isset($data['component_name']) && !empty($data['component_name'])) {
            TaxComponent::create([
                'component_name' => $data['component_name'],
                'sales_tax_id' => $data['sales_tax_id'],
                'new_tax_component_rate' => $data['new_tax_component_rate'],
                'tax_code_total' => $data['tax_code_total'],
                'tax_code_id' => $taxCode->id,
            ]);
        }
        return $taxCode;
    }

    public function update(array $data, int $id)
    {
        $taxCodeDelete = $this->findOrFail($id);
        if(!empty($taxCodeDelete)){
            $taxCodeDelete->delete();
            $taxCode = TaxCode::query()->create([
                'sort_order' => $data['sort_order'],
                'tax_code' => $data['tax_code'],
                'tax_code_label' => $data['tax_code_label'],
                'notes' => $data['notes'],
                'effective_date' => date('Y-m-d', strtotime($data['effective_date'])),
            ]);
        }

        $taxIds = $data['tax_id'];
        $taxComponent = $data['tax_component_id'];
        $taxRate = $data['tax_rate'];
        $glAccountName = $data['gl_account_name'];

        TaxCodeComponent::query()->where('tax_code_id', $id)->delete();

        if (isset($taxComponent) && !empty($taxComponent)) {
            foreach ($taxComponent as $index => $taxComp) {
                TaxCodeComponent::create([
                    'tax_code_id' => $taxCode->id,
                    'tax_component_id' => $taxComp,
                    'rate' => $taxRate[$index],
                    'gl_account_name' => $glAccountName[$index],
                ]);
            }
        }

        TaxComponent::query()->where('tax_code_id', $id)->delete();

        if (isset($data['component_name']) && !empty($data['component_name'])) {
            TaxComponent::create([
                'component_name' => $data['component_name'],
                'sales_tax_id' => $data['sales_tax_id'],
                'new_tax_component_rate' => $data['new_tax_component_rate'],
                'tax_code_total' => $data['tax_code_total'],
                'tax_code_id' => $taxCode->id,
            ]);
        }
        return $taxCode;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getTaxCodeList($request)
    {
        $query = TaxCode::query();
        if (!empty($request->tax_code)) {
            $query->where('tax_code', 'like', '%' . $request->tax_code . '%');
        }
        if (!empty($request->tax_code_label)) {
            $query->where('tax_code_label', 'like', '%' . $request->tax_code_label . '%');
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
        $taxAuthoritys = $this->getTaxCodeList($request);
        $total         = $taxAuthoritys->count();

        $totalFilter = $this->getTaxCodeList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getTaxCodeList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno            = ++$i;
            $value->sort_order     = $value->sort_order ?? '';
            $value->tax_code       = $value->tax_code ?? '';
            $value->tax_code_label = $value->tax_code_label ?? '';
            $value->current_rate   = $this->taxCodeService->getCurrentRate($value->id) ?? '';
            $value->rate_breakdown = $this->taxCodeService->getRateBreakDown($value->id) ?? '';
            $value->notes          = $value->notes ?? '';
            $value->action         = "<div class='dropup'>
                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                    <i class='bx bx-dots-vertical-rounded icon-color'></i>
                </button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item showbtn text-warning' href='" . route('tax_codes.show', $value->id) . "'>
                        <i class='bx bx-show me-1 icon-warning'></i> Show
                    </a>
                    <a class='dropdown-item editbtn text-success' href='" . route('tax_codes.edit', $value->id) . "'>
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
