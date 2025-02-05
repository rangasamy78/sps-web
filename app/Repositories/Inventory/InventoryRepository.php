<?php

namespace App\Repositories\Inventory;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryRepository
{
    public function save(array $data)
    {
        $query = Inventory::query()
            ->create($data);
        return $query->id;
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

        
        $query = Product::where('inventory_in_stock', '!=', 0)
            ->with([
                'product_category',
                'country',
                'product_type',
                'product_group',
                'product_color'
            ])
            ->orderBy($columnName, $columnSortOrder); 

        
        $total = $query->count();

    
        $arrData = $query->skip($start)->take($rowPerPage)->get();
        
        $arrData->map(function ($value) {
            $value->id = $value->id ?? '';
            $value->product_id = $value->id ?? '';
            $value->product_name = $value->product_name ?? '';
            $value->inventory = "In Stock: " . ($value->inventory_in_stock ?? '') . "<br>Committed: " . $value->inventory_committed . "<br>Available: " . $value->inventory_available;
            $value->product_type_id = $value->product_type->product_type;
            $value->product_category_id = $value->product_category->product_category_name ?? '';
            $value->product_origin = $value->country->country_name ?? '';
            $value->product_colors = $value->product_color->product_color ?? '';
            $value->product_group_id = $value->product_group->product_group_name ?? '';
            $value->action = '';
            $value->details = [
                'product_id' => $value->product_id,
                'lot_block' => $value->lot_block,
                'bundle' => $value->bundle,
                'supp_ref' => $value->supp_ref,
                'location' => $value->location,
                'bin' => $value->bin,
                'on_hand' => $value->on_hand,
                'available' => $value->available
            ];
        });

        // Response
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $arrData,
        );

        return response()->json($response);
    }
}