<?php

namespace App\Repositories\Quote\Lines;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\QuoteOptionLineProduct;

class QuoteOptionLineProductRepository
{
    public function findOrFail(int $id)
    {
        return QuoteOptionLineProduct::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return QuoteOptionLineProduct::insert($data);
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
        $query = QuoteOptionLineProduct::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    //option line item
    public function getOptionLineProduct(Request $request)
    {
        $name = $request->get('name');
        $type = $request->get('type');
        $category = $request->get('category');
        $priceRange = $request->get('price_range');
        $subCategory = $request->get('sub_category');
        $group = $request->get('group');

        $products = Product::with([
            'product_type',
            'product_category',
            'product_sub_category',
            'product_group',
            'product_price.price_range'
        ]);

        // Apply filters dynamically
        if (!empty($name)) {
            $products->where(function ($query) use ($name) {
                $query->where('product_name', 'LIKE', "%{$name}%")
                    ->orWhere('product_sku', 'LIKE', "%{$name}%");
            });
        }
        if (!empty($type)) {
            $products->where('product_type_id', $type);
        }
        if (!empty($category)) {
            $products->where('product_category_id', $category);
        }
        if (!empty($priceRange)) {
            $products->whereHas('product_price', function ($query) use ($priceRange) {
                $query->where('price_range_id', $priceRange);
            });
        }
        if (!empty($subCategory)) {
            $products->where('product_sub_category_id', $subCategory);
        }
        if (!empty($group)) {
            $products->where('product_group_id', $group);
        }

        return $products;
    }

    public function dataTableOptionLineProduct(Request $request)
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
        $aboutUsOptions = $this->getOptionLineProduct($request);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getOptionLineProduct($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getOptionLineProduct($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {

            $value->product_name = $value->product_name ?? '';
            $value->product_sku  = $value->product_sku ?? 'N/A';
            $value->type         = $value->product_type->product_type ?? 'N/A';
            $value->category    = $value->product_category->product_category_name ?? 'N/A';
            $value->group       = $value->product_group->product_group_name ?? 'N/A';
            $value->price_range  = $value->product_price->price_range->product_price_range ?? 'N/A';
            $value->price      = $value->product_price->homeowner_price ?? 'N/A';
            $value->check       = '<input type="checkbox" class="form-check-input product_checkbox" value="' . $value->id . '" data-id="' . $value->id . '">';
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
