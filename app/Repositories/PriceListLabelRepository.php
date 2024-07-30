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
    public function getPriceListLabelsList()
    {
        $query = PriceListLabel::query();
        return $query;
    }
    public function dataTable(Request $request)
    {
        $draw                 =         $request->get('draw');
        $start                =         $request->get("start");
        $rowPerPage           =         $request->get("length");
        $orderArray           =         $request->get('order');
        $columnNameArray      =         $request->get('columns');
        $searchArray          =         $request->get('search');
        $columnIndex          =         $orderArray[0]['column'];
        $columnName           =         $columnNameArray[$columnIndex]['data'];
        $columnSortOrder      =         $orderArray[0]['dir'];
        $searchValue          =         $searchArray['value'];
        $PriceListLabels = $this->getPriceListLabelsList();
        $total = $PriceListLabels->count();

        $totalFilter = $this->getPriceListLabelsList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('price_label', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();
        $arrData = $this->getPriceListLabelsList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('price_label', 'like', '%' . $searchValue . '%')
                ->orwhere('price_code', 'like', '%' . $searchValue . '%')
                ->orwhere('default_discount', 'like', '%' . $searchValue . '%')
                ->orwhere('default_margin', 'like', '%' . $searchValue . '%')
                ->orwhere('default_markup', 'like', '%' . $searchValue . '%')
                ->orwhere('sales_person_commission', 'like', '%' . $searchValue . '%');
        }
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->price_label      = $value->price_label ?? '';
            $value->price_code       = $value->price_code ?? '';
            $value->default_discount = $value->default_discount ?? '';
            $value->default_margin   = $value->default_margin ?? '';
            $value->default_markup   = $value->default_markup ?? '';
            $value->sales_person_commission = $value->sales_person_commission ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "' name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "' name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
