<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Http\Request;
class ContactRepository
{
    public function save(array $data)
    {
        $query = Contact::query()
            ->create($data);
        return $query->id;
    }

    public function getContactList($request)
    {
        $query = Contact::query();
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
        $Contact   = $this->getContactList($request);
        $total      = $Contact->count();

        $totalFilter = $this->getContactList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getContactList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->contact_name      = $value->contact_name ?? '';
            $value->address        = $value->address ?? '';
            $value->primary_phone = $value->primary_phone ?? '';
            $value->internal_notes   = $value->internal_notes ?? '';
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
