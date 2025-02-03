<?php

namespace App\Repositories\Quote;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\QuoteContact;

class ContactRepository
{
    public function findOrFail(int $id)
    {
        return QuoteContact::query()
            ->findOrFail($id);
    }
    public function store(array $data)
    {
        $visitId = $data['quote_id'];
        $contactIds = $data['contact_id'];
        foreach ($contactIds as $contactId) {
            if (!empty($contactId)) {
                QuoteContact::create([
                    'contact_id' => $contactId,
                    'quote_id' => $visitId,
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
            $quoteContact = QuoteContact::where('contact_id', $contactId)->first();
            if (!$quoteContact) {
                $value->select_all = '<div class="form-check"><input type="checkbox" class="form-check-input contact-checkbox" id="contact_' . $contactId . '" name="contact_id[]" value="' . $contactId . '" data-id="' . $contactId . '"></div>';
            } else {
                $value->select_all = '<div class=""><button class="btn btn-danger btn-sm rounded-circle delete-contact p-2" data-id="' . $quoteContact->id . '"><i class="fi fi-rr-cross"></i></button></div>';
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

    public function getCustomerContactList(Request $request, $id)
    {
        $query = Contact::where('type', operator: 'customer')
            ->where('type_id', $id);
        return $query;
    }

    public function dataTableCustomerContact(Request $request, $id)
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
        $aboutUsOptions = $this->getCustomerContactList($request, $id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getCustomerContactList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getCustomerContactList($request, $id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $contactId = $value->id ?? null;
            $quoteContact = QuoteContact::where('contact_id', $contactId)->first();
            $value->check = !$quoteContact
                ? ''
                : '<div class="form-check"><i class="fi fi-rr-check text-success"></i></div>';
            $value->contact_name = $value->contact_name ?? '';
            $value->address = $value->address ?? '';
            $value->fax_email = ($value->fax ?? '') . '-' . ($value->email ?? '');
            $value->lot_subdivision = ($value->lot ?? '') . '-' . ($value->sub_division ?? '');
            $value->phone = $value->mobile ?? '';
            $value->notes = $value->internal_notes ?? '';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'>";
            if ($quoteContact) {
                $value->action .= "<a class='dropdown-item delete-contact text-warning' href='javascript:void(0);' data-id='$quoteContact->id'><i class='fi fi-rr-cross-small'></i> Remove Contact from</a>";
            } else {
                $value->action .= "<a class='dropdown-item addContactBtn text-dark' href='javascript:void(0);' data-id='{$value->id}'><i class='fi fi-rr-plus'></i> Add Contact</a>";
            }
            $value->action .= "<a class='dropdown-item deleteCustomerContactBtn text-danger' href='javascript:void(0);' data-id='{$value->id}'><i class='bx bx-trash me-1 icon-danger'></i> Delete Contact</a><a class='dropdown-item editContactBtn text-success' href='javascript:void(0);' data-id='{$value->id}' ><i class='bx bx-edit-alt me-1 icon-success'></i> Update Contact Details</a><a class='dropdown-item setupNewContactBtn text-info' href='javascript:void(0);' data-id='{$value->id}' data-bs-toggle='modal' data-bs-target='#saveCustomerContactModal'><i class='fi fi-rr-add-document'></i> Setup New Contact</a></div></div>";
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
