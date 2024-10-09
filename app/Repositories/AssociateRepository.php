<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\Associate;
use Illuminate\Http\Request;

class AssociateRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{

    public function findOrFail(int $id)
    {
        return Associate::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Associate::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = Associate::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getAssociateList($request)
    {

        $query = Associate::with('associate_type', 'location', 'user');

        if (!empty($request->associate_name_code_contact_search)) {
            $query->where(function ($q) use ($request) {
                $q->where('associate_name', 'like', '%' . $request->associate_name_code_contact_search . '%')
                    ->orWhere('associate_code', 'like', '%' . $request->associate_name_code_contact_search . '%')
                    ->orWhere('contact_name', 'like', '%' . $request->associate_name_code_contact_search . '%');
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
                    ->orWhere('accounting_email', 'like', '%' . $request->phone_fax_email_search . '%')
                    ->orWhere('email', 'like', '%' . $request->phone_fax_email_search . '%');
            });
        }
        if (!empty($request->associate_type_search)) {
            $associateSearch = !empty($request->associate_type_search) ? $request->associate_type_search : '';
            $query->whereIn('associate_type_id', $associateSearch);
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
        $associate  = $this->getAssociateList($request);
        $total      = $associate->count();

        $totalFilter = $this->getAssociateList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getAssociateList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno               = ++$i;
            $value->associate_name    = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->associate_name ?? '') . "</a>";
            $value->associate_type_id = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->associate_type->customer_type_name ?? '') . "</a>";
            $value->location_id       = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->location->company_name ?? '') . "</a>";
            $value->address_combined  = trim(
                "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->address ?? '') . "</a><br>" .
                "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->contact_name ?? '') . "</a><br>" .
                "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->city ?? '') . "</a><br>" .
                "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->state ?? '') . "</a><br>" .
                "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->zip ?? '') . "</a>"
            );

            $phoneParts = [];
            if (!empty($value->primary_phone)) {
                $phoneParts[] = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>P: {$value->primary_phone}</a>";
            }
            if (!empty($value->secondary_phone)) {
                $phoneParts[] = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>F: {$value->secondary_phone}</a>";

            }
            if (!empty($value->mobile)) {
                $phoneParts[] = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>M: {$value->mobile}</a>";

            }
            $value->phone_combined = !empty($phoneParts) ? implode('<br>', $phoneParts) : '';

            $emailParts = [];
            if (!empty($value->email)) {
                $emailParts[] = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>E: {$value->email}</a>";

            }
            if (!empty($value->website)) {
                $emailParts[] = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>W: {$value->website}</a>";

            }
            $value->email_combined = !empty($emailParts) ? implode('<br>', $emailParts) : '';
            $value->internal_notes = "<a href='" . route('associates.show', $value->id) . "' class='text-secondary'>" . ($value->internal_notes ?? '') . "</a>";
            $value->status         = $value->status == 1
            ? '<button class="btn btn-success btn-sm change_status" data-id="' . $value->id . '">Active</button>'
            : '<button class="btn btn-danger btn-sm change_status" data-id="' . $value->id . '">Inactive</button>';

            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i></button>
                <div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='" . route('associates.show', $value->id) . "' data-id='" . $value->id . "' >
                <i class='bx bx-show me-1 icon-warning'></i> Show</a>
                <a class='dropdown-item editbtn text-success' href='" . route('associates.edit', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
                <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div></div>";
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
