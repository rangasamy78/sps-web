<?php

namespace App\Repositories\Quote\Lines;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\QuoteOptionLineService;

class QuoteOptionLineServiceRepository
{
    public function findOrFail(int $id)
    {
        return QuoteOptionLineService::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return QuoteOptionLineService::insert($data);
    }

    public function update(array $data, $id)
    {
        if (!isset($data['is_sold_as'])) {
            $data['is_sold_as'] = 0;
        }

        if (!isset($data['is_tax'])) {
            $data['is_tax'] = 0;
        }

        if (!isset($data['is_hide_line'])) {
            $data['is_hide_line'] = 0;
        }
        $query = QuoteOptionLineService::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    //option line item
    public function getOptionLineService(Request $request)
    {
        $name = $request->get('name');
        $type = $request->get('type');
        $category = $request->get('category');
        $priceRange = $request->get('priceRange');

        $services = Service::with([
            'service_categories',
            'service_price.price_range'
        ]);

        // Apply filters dynamically
        if (!empty($name)) {
            $services->where(function ($query) use ($name) {
                $query->where('service_name', 'LIKE', "%{$name}%")
                    ->orWhere('service_sku', 'LIKE', "%{$name}%");
            });
        }
        if (!empty($type)) {
            $services->where('service_type_id', $type);
        }
        if (!empty($category)) {
            $services->where('service_category_id', $category);
        }
        if (!empty($priceRange)) {
            $services->whereHas('service_price', function ($query) use ($priceRange) {
                $query->where('price_range_id', $priceRange);
            });
        }

        return $services;
    }

    public function dataTableOptionLineService(Request $request)
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
        $aboutUsOptions = $this->getOptionLineService($request);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getOptionLineService($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getOptionLineService($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {

            $value->service_name = $value->service_name ?? '';
            $value->service_sku  = $value->service_sku ?? 'N/A';
            $value->category    = $value->service_categories->service_categories ?? 'N/A';
            $value->price      = $value->service_price->homeowner_price ?? 'N/A';
            $value->check       = '<input type="checkbox" class="form-check-input service_checkbox" value="' . $value->id . '" data-id="' . $value->id . '">';
            return $value;
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
