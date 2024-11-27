<?php

namespace App\Repositories\Customer;

use App\Models\Contact;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;

class ContactRepository
{
    public $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    public function findOrFail(int $id)
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
    public function update(array $data, int $id)
    {
        return Contact::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function getContactList($request, $typeId)
    {
        $query = Contact::query()->ofType($typeId, CONTACT::CUSTOMER);
        return $query;
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
            $value->address            = $this->customerService->__formataddressParts($value);
            $value->primary_phone      = $value->primary_phone ?? '';
            $value->internal_notes     = $value->internal_notes ?? '';
            $value->is_ship_to_address = isset($value->is_ship_to_address) ? $this->customerService->__formatContactImageNoteParts($value) : '';
            $value->action             = "<div class='dropup'>
                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                    <i class='bx bx-dots-vertical-rounded icon-color'></i>
                </button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item showbtn text-warning' href='" . route('customers.show', $value->id) . "'>
                        <i class='bx bx-show me-1 icon-warning'></i> Show
                    </a>
                    <a class='dropdown-item editbtn text-success' href='" . route('customers.edit', $value->id) . "'>
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
