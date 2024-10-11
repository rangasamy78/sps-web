<?php

namespace App\Repositories\Expenditure;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Services\Expenditure\ExpenditureService;

class ExpenditureRepository
{
    public $expenditureService;

    public function __construct(ExpenditureService $expenditureService)
    {
        $this->expenditureService = $expenditureService;
    }

    public function findOrFail(int $id): Model
    {
        return Contact::query()
            ->findOrFail($id);
    }

    public function save(array $data)
    {
        $query = Contact::query()
            ->create($data);
        return $query->id;
    }

    public function getContactList($request, $typeId)
    {
        $query = Contact::query()->ofType($typeId, CONTACT::EXPENDITURE);
        return $query;
    }

    public function delete(int $id)
    {
        Contact::findOrFail($id)->delete();
    }

    public function update(array $data, int $id)
    {
        return Contact::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function dataTable(Request $request, $typeId)
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
        $Contact    = $this->getContactList($request, $typeId);
        $total      = $Contact->count();

        $totalFilter = $this->getContactList($request, $typeId);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getContactList($request, $typeId);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->contact_name       = $value->contact_name ?? '';
            $value->address            = $this->expenditureService->__formataddressParts($value);
            $value->primary_phone      = $value->primary_phone ?? '';
            $value->internal_notes     = "<div class='d-flex align-items-center'>" . (!empty($value->internal_notes) ? "<span class='avatar-initial rounded bg-label-secondary me-2' data-bs-toggle='tooltip' data-bs-placement='top'   title='" . htmlspecialchars($value->internal_notes ? $value->internal_notes : 'Internal Notes', ENT_QUOTES, 'UTF-8') . "'><i class='bx bx-note bx-sm'></i></span>" :'') . "</div>";
            // $value->is_ship_to_address = isset($value->is_ship_to_address) ? $this->expenditureService->__formatContactImageNoteParts($value) : '';
            $value->action             = "<div class='dropup'>
                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                    <i class='bx bx-dots-vertical-rounded icon-color'></i>
                </button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "'>
                        <i class='bx bx-trash me-1 icon-danger'></i> Delete
                    </a>
                </div>
            </div>";
            /*
            $value->action             = "<div class='dropup'>
            <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded icon-color'></i>
            </button>
            <div class='dropdown-menu'>
                <a class='dropdown-item editbtn text-success' data-bs-target='#offcanvasRight'>
                    <i class='bx bx-edit-alt me-1 icon-success'></i> Edit
                </a>
                <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "'>
                    <i class='bx bx-trash me-1 icon-danger'></i> Delete
                </a>
            </div>
        </div>";*/
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
