<?php

namespace App\Repositories;

use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class FreightVendorRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Expenditure::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Expenditure::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
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

    public function getFreightVendorList($request)
    {
        $query = Expenditure::with('vendor_types', 'company', 'payment_method');
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
        $freight    = $this->getFreightVendorList($request);
        $total      = $freight->count();

        $totalFilter = $this->getFreightVendorList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getFreightVendorList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno              = ++$i;
            $value->expenditure_name ="<a href='" . route('expenditures.show', $value->id) . "' class='text-secondary'>" . ($value->expenditure_name ?? '') . "</a>";
            $value->print_name = $value->print_name ?? '';
            $value->expenditure_type_id = $value->vendor_types->vendor_type_name ?? '';

            $value->address_combined = trim(
                ($value->address ?? '') . "<br>" .
                ($value->city ?? '') . "<br>" .
                ($value->state ?? '') . "<br>" .
                ($value->zip ?? '') . "<br>" .
                ($value->country->country_name ?? ''));
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
                $value->phone_combined = !empty($phoneParts) ?  implode('<br>', $phoneParts)  : '';
                $value->parent_location_id = $value->company->company_name ?? '';
                $value->payment_method_id = $value->payment_method->payment_method_name ?? '';
                $value->account = $value->account ?? '';
                $value->status = $value->status == 1
                ? 'Active' : 'Inactive';
             
            $value->action = "";
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