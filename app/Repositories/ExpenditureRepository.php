<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\Expenditure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ExpenditureRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id): Model
    {
        return Expenditure::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Expenditure::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        $data['is_generic_expenditure'] = isset($data['is_generic_expenditure']) ? 1 : 0;
        $data['is_allow_login'] = isset($data['is_allow_login']) ? 1 : 0;
        $data['is_print_1099'] = isset($data['is_print_1099']) ? 1 : 0;
        $data['is_frieght_expenditure'] = isset($data['is_frieght_expenditure']) ? 1 : 0;
        $data['is_sub_contractor'] = isset($data['is_sub_contractor']) ? 1 : 0;
        $query = Expenditure::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getExpenditureList($request)
    {
        $query = Expenditure::with('vendor_types', 'company', 'payment_method');
        // $query = Expenditure::query()->with('vendor_types');
        if (!empty($request->expenditure_name_search)) {
            $query->where(function ($q) use ($request) {
                $q->where('expenditure_name', 'like', '%' . $request->expenditure_name_search . '%')
                    ->orWhere('print_name', 'like', '%' . $request->expenditure_name_search . '%')
                    ->orWhere('expenditure_code', 'like', '%' . $request->expenditure_name_search . '%');
            });
        }
        if (!empty($request->address_search)) {
            $query->where('address', 'like', '%' . $request->address_search . '%');
        }

        if (!empty($request->phone_fax_email_search)) {
            $query->where(function ($q) use ($request) {
                $q->where('primary_phone', 'like', '%' . $request->phone_fax_email_search . '%')
                    ->orWhere('secondary_phone', 'like', '%' . $request->phone_fax_email_search . '%')
                    ->orWhere('mobile', 'like', '%' . $request->phone_fax_email_search . '%')
                    ->orWhere('fax', 'like', '%' . $request->phone_fax_email_search . '%')
                    ->orWhere('email', 'like', '%' . $request->phone_fax_email_search . '%');
            });
        }
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex = $orderArray[0]['column'] ?? '0';
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName = 'created_at';
        $expenditures = $this->getExpenditureList($request);
        $total = $expenditures->count();

        $totalFilter = $this->getExpenditureList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getExpenditureList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->expenditure_name = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'><b>" . ($value->expenditure_name ?? '') . "</b></a>";
            $value->print_name = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . ($value->print_name ?? '') . "</a>";
            $value->expenditure_type_id = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . ($value->vendor_types->vendor_type_name ?? '') . "</a>";

            $value->address_combined = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . (trim(
                ($value->address ?? '') . "<br>" .
                ($value->city ?? '') . "<br>" .
                ($value->state ?? '') . "<br>" .
                ($value->zip ?? '') . "<br>" .
                ($value->country->country_name ?? ''))) . "</a>";
            $phoneParts = [];
            if (!empty($value->primary_phone)) {
                $phoneParts[] = "P: {$value->primary_phone}";
            }
            if (!empty($value->secondary_phone)) {
                $phoneParts[] = "P: {$value->secondary_phone}";
            }
            if (!empty($value->fax)) {
                $phoneParts[] = "F: {$value->fax}";
            }
            if (!empty($value->mobile)) {
                $phoneParts[] = "M: {$value->mobile}";
            }
            if (!empty($value->email)) {
                $phoneParts[] = "E: {$value->email}";
            }
            if (!empty($value->website)) {
                $phoneParts[] = "W: {$value->website}";
            }
            $value->phone_combined = !empty($phoneParts) ? "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . implode('<br>', $phoneParts) . "</a>" : '';
            $value->parent_location_id = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . ($value->company->company_name ?? '') . "</a>";
            $value->payment_method_id = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . ($value->payment_method->payment_method_name ?? '') . "</a>";
            $value->account = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . ($value->account ?? '') . "</a>";
            $value->internal_notes = "<a href='" . route('expenditures.show', $value->id) . "' class='expenditures-link'>" . ($value->internal_notes ?? '') . "</a>";
            $value->status = $value->status == 1
            ? '<button class="btn btn-success btn-sm change_status" data-id="' . $value->id . '">Active</button>'
            : '<button class="btn btn-danger btn-sm change_status" data-id="' . $value->id . '">Inactive</button>';

            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i></button>
                <div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='" . route('expenditures.show', $value->id) . "' data-id='" . $value->id . "' >
                <i class='bx bx-show me-1 icon-warning'></i> Show</a>
                <a class='dropdown-item editbtn text-success' href='" . route('expenditures.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
                <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
            return $value;
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
