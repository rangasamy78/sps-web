<?php

namespace App\Repositories\SaleOrder;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\SaleOrderContact;

class ContactRepository
{
    public function findOrFail(int $id)
    {
        return SaleOrderContact::query()
            ->findOrFail($id);
    }

    public function save(array $data)
    {
        $saleOrderId = $data['sales_order_id'];
        $contactIds = $data['contact_id'];
        foreach ($contactIds as $contactId) {
            if (!empty($contactId)) {
                SaleOrderContact::create([
                    'contact_id' => $contactId,
                    'sales_order_id' => $saleOrderId,
                ]);
            }
        }
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getContactList($id)
    {
        $query = Contact::where('type', 'customer')
            ->where('type_id', $id);
        return $query;
    }

    public function dataTable(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'created_at';
        $aboutUsOptions = $this->getContactList($id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getContactList($id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getContactList($id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $contactId = $value->id ?? null;
            $contactName = $value->contact_name ?? '';
            $saleOrderContact = SaleOrderContact::where('contact_id', $contactId)->first();
            if (!$saleOrderContact) {
                $value->select_all = '<div class="form-check"><input type="checkbox" class="form-check-input contact-checkbox" id="contact_' . $contactId . '" name="contact_id[]" value="' . $contactId . '" data-id="' . $contactId . '"></div>';
            } else {
                $value->select_all = '<div class=""><button class="btn btn-danger btn-sm rounded-circle delete-contact p-1" data-id="' . $saleOrderContact->id . '"><i class="fi fi-rr-cross"></i></button></div>';
            }
            $value->contact_name = $value->contact_name ?? '';
            $value->lot_subdivision = ($value->lot ?? '') . '-' . ($value->sub_division ?? '');
            $value->phone = $value->mobile ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getBillToContactList(Request $request, $id)
    {
        $query = Contact::where('type', operator: 'customer')
            ->where('type_id', $id);
        return $query;
    }

    public function dataTableBilltoContact(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'created_at';
        $aboutUsOptions = $this->getBillToContactList($request, $id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getBillToContactList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getBillToContactList($request, $id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $contactId = $value->id ?? null;
            $saleOrderContact = SaleOrderContact::where('contact_id', $contactId)->first();
            $value->check = !$saleOrderContact
                ? ''
                : '<div class="form-check"><i class="fi fi-rr-check text-success"></i></div>';
            $value->contact_name = $value->contact_name ?? '';
            $value->address = $value->address ?? '';
            $value->fax_email = ($value->fax ?? '') . '-' . ($value->email ?? '');
            $value->lot_subdivision = ($value->lot ?? '') . '-' . ($value->sub_division ?? '');
            $value->phone = $value->mobile ?? '';
            $value->notes = $value->internal_notes ?? '';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'>";
            if ($saleOrderContact) {
                $value->action .= "<a class='dropdown-item delete-contact text-warning' href='javascript:void(0);' data-id='$saleOrderContact->id'><i class='fi fi-rr-cross-small'></i> Remove Contact from</a>";
            } else {
                $value->action .= "<a class='dropdown-item addContactBtn text-dark' href='javascript:void(0);' data-id='{$value->id}'><i class='fi fi-rr-plus'></i> Add Contact</a>";
            }
            $value->action .= "<a class='dropdown-item deleteBillToContactBtn text-danger' href='javascript:void(0);' data-id='{$value->id}'><i class='bx bx-trash me-1 icon-danger'></i> Delete Contact</a><a class='dropdown-item editContactBtn text-success' href='javascript:void(0);' data-id='{$value->id}' ><i class='bx bx-edit-alt me-1 icon-success'></i> Update Contact Details</a><a class='dropdown-item setupNewContactBtn text-info' href='javascript:void(0);' data-id='{$value->id}' data-bs-toggle='modal' data-bs-target='#saveCustomerContactModal'><i class='fi fi-rr-add-document'></i> Setup New Contact</a></div></div>";
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
