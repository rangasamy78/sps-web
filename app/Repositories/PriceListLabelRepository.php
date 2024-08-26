<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\PriceListLabel;
use App\Models\PriceListLabelLocation;
use Illuminate\Database\Eloquent\Model;
use App\Models\PriceListLabelCustomerType;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class PriceListLabelRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id): Model
    {
        return PriceListLabel::with('priceListLocation', 'priceListCustomerType')->findOrFail($id);
    }

    public function store(array $data): Model
    {
        $priceListLabel = PriceListLabel::query()->create($data);
        if (isset($data['customer_type_id']) && is_array($data['customer_type_id'])) {
            $priceListLabelCustomerType = $data['customer_type_id'];
            $priceListLabel->priceListCustomerType()->createMany($priceListLabelCustomerType);
        }
        if (isset($data['location_id']) && is_array($data['location_id'])) {
            $priceListLabelLocation = $data['location_id'];
            $priceListLabel->priceListLocation()->createMany($priceListLabelLocation);
        }
        return $priceListLabel;
    }

    public function update(array $data, int $id)
    {
        $priceListLabel = PriceListLabel::findOrFail($id);
        $priceListLabel->update($data);
        if (isset($data['customer_type_id']) && is_array($data['customer_type_id'])) {
            $priceListLabel->priceListCustomerType()->delete();
            $priceListLabel->priceListCustomerType()->createMany($data['customer_type_id']);
        }
        if (isset($data['location_id']) && is_array($data['location_id'])) {
            $priceListLabel->priceListLocation()->delete();
            $priceListLabel->priceListLocation()->createMany($data['location_id']);
        }
        return $priceListLabel->load('priceListCustomerType', 'priceListLocation');
    }

    public function delete(int $id)
    {
        $deleted = $this->findOrFail($id)->delete();
        if ($deleted) {
            PriceListLabelCustomerType::where('price_list_label_id', $id)->delete();
            PriceListLabelLocation::where('price_list_label_id', $id)->delete();
        }
        return $deleted;
    }
    public function getPriceListLabelsList($request)
    {
        $query = PriceListLabel::query();
        if (!empty($request->price_label_search) ) {
            $query->where('price_label', 'like', '%' . $request->price_label_search . '%');
        }
        if (!empty($request->price_code_search) ) {
            $query->where('price_code', 'like', '%' . $request->price_code_search . '%');
        }
        if (!empty($request->discount_search) ) {
            $query->where('default_discount', $request->discount_search);
        }
        if (!empty($request->margin_search) ) {
            $query->where('default_margin', $request->margin_search);
        }
        if (!empty($request->markup_search) ) {
            $query->where('default_markup', $request->markup_search);
        }
        if (!empty($request->sales_person_commission_search) ) {
            $query->where('sales_person_commission', $request->sales_person_commission_search);
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
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $PriceListLabels = $this->getPriceListLabelsList($request);
        $total           = $PriceListLabels->count();

        $totalFilter = $this->getPriceListLabelsList($request);
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getPriceListLabelsList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);

        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->price_label             = $value->price_label ?? '';
            $value->price_code              = $value->price_code ?? '';
            $value->default_discount        = $value->default_discount ?? '';
            $value->default_margin          = $value->default_margin ?? '';
            $value->default_markup          = $value->default_markup ?? '';
            $value->sales_person_commission = $value->sales_person_commission ?? '';
            $value->action                  = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
