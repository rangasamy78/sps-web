<?php

namespace App\Repositories\Visit;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\VisitContact;

class ContactRepository
{
    public function findOrFail(int $id)
    {
        return VisitContact::query()
            ->findOrFail($id);
    }
    public function save(array $data)
    {
        $visitId = $data['visit_id'];
        $contactIds = $data['contact_id'];
        foreach ($contactIds as $contactId) {
            if (!empty($contactId)) {
                VisitContact::create([
                    'contact_id' => $contactId,
                    'visit_id' => $visitId,
                ]);
            }
        }
    }
    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getContactList(Request $request, $id)
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
        $aboutUsOptions = $this->getContactList($request, $id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getContactList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getContactList($request, $id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $contactId = $value->id ?? null;
            $opportunityContact = VisitContact::where('contact_id', $contactId)->first();
            if ($opportunityContact) {
                $value->check = '<div class="form-check"><input type="checkbox" disabled class="form-check-input contact-checkbox" id="contact_' . $contactId . '" name="contact_id[]" value="' . $contactId . '" data-id="' . $contactId . '"></div>';
            } else {
                $value->check = '<div class="form-check"><input type="checkbox" class="form-check-input contact-checkbox" id="contact_' . $contactId . '" name="contact_id[]" value="' . $contactId . '" data-id="' . $contactId . '"></div>';
            }
            $value->contact_name = $value->contact_name ?? '';
            $value->address = $value->address ?? '';
            $value->phone = $value->mobile ?? '';
            $value->notes = $value->internal_notes ?? '';
            if ($value->is_ship_to_address == 1) {
                $value->action = '<img src="' . asset('public/images/logistic.png') . '"  width="35px" height="35px"/>';
            } else {
                $value->action = "";
            }
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
