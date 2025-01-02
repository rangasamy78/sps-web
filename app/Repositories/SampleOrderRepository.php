<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\SampleOrder;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CrudRepositoryInterface;

class SampleOrderRepository implements CrudRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return SampleOrder::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SampleOrder::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SampleOrder::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getProductSampleOrderList($request, $id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('SampleOrder ID is required');
        }
        $productQuery = DB::table('sample_order_products')
            ->join('products', 'sample_order_products.product_id', '=', 'products.id')
            ->where('sample_order_id', $id)
            ->select(
                'sample_order_id as id',
                'products.product_name as item_name',
                'product_quantity as quantity',
                'product_unit_price as unit_price',
                'product_amount as amount',
                'is_tax as tax',
                'product_description as description',
                DB::raw("'product' as type"),
                DB::raw('NULL as serialNum') // Placeholder for serialNum
            );

        $serviceQuery = DB::table('sample_order_services')
            ->join('services', 'sample_order_services.service_id', '=', 'services.id')
            ->where('sample_order_id', $id)
            ->select(
                'sample_order_id as id',
                'services.service_name as item_name',
                'service_quantity as quantity',
                'service_unit_price as unit_price',
                'service_amount as amount',
                'is_tax as tax',
                'service_description as description',
                DB::raw("'service' as type"),
                DB::raw('NULL as serialNum') // Placeholder for serialNum
            );

        return $productQuery->unionAll($serviceQuery);
    }


    public function dataTable(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex = $orderArray[0]['column'] ?? 0;
        $columnName = $columnNameArray[$columnIndex]['data'] ?? 'quantity'; // Default column
        $columnSortOrder = $orderArray[0]['dir'] ?? 'asc';

        // Ensure column name exists in the result set
        if (!in_array($columnName, ['id', 'item_name', 'quantity', 'unit_price', 'amount', 'tax', 'description', 'type', 'serialNum'])) {
            $columnName = 'quantity'; // Default to a valid column
        }

        $query = $this->getProductSampleOrderList($request, $id);

        $totalRecords = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->count();

        $data = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();

        $data->map(function ($value) {
            $value->item_name = $value->item_name ?? '';
            $value->current_qty = 0;
            $value->tax = ($value->tax == 1 ? "<i class='fi fi-rr-circle-y text-dark fw-bold'></i>" : "<i class='fi fi-rr-circle-n text-dark fw-bold'></i>") . "<input type='hidden' readonly class='border-0 text-secondary tax' value='" . ($value->tax ?? '') . "'>";
            $value->slab = '';
            $value->serialNum = ''; // Ensure serialNum exists
            $value->location = '';
            $value->barcode = '';
            $value->lot = '';
            $value->bundle = '';
            $value->supp_ref = '';
            $value->quantity = $value->quantity ?? '';
            $value->unit_price = "<input type='hidden' readonly class='border-0 text-secondary unit-price' value='" . ($value->unit_price ?? '') . "'>" . ($value->unit_price ?? '');
            $value->amount = $value->amount ?? '';
            $value->action = "<a class='dropdown-item showbtn text-warning' href='" . route('create.edit_product', $value->id) . "' data-id='{$value->id}'><i class='bx bxs-edit'></i></a>";
        });

        return response()->json([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data,
        ]);
    }

    public function getProductList($request)
    {
        $name = $request->get('name');
        $type = $request->get('type');
        $category = $request->get('category');
        $supplier = $request->get('supplier');
        $products = Product::with('product_type');
        if (!empty($name)) {
            $products->where('product_name', 'LIKE', "%{$name}%");
        }
        if (!empty($type)) {
            $products->where('product_type_id', $type);
        }
        if (!empty($category)) {
            $products->where('product_category_id', $category);
        }
        if (!empty($supplier)) {
            $products->where('preferred_supplier_id', $supplier);
        }
        return $products;
    }

    public function searchProductDataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'created_at';
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $query = $this->getProductList($request);
        $totalRecords = $query->count();
        $filteredData = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data = $filteredData->map(function ($product) {
            return [
                'product_name' => $product->product_name ?? '',
                'product_sku'  => $product->product_sku ?? 'N/A',
                'type'         => $product->product_type->product_type ?? 'N/A',
                'icon' => '<img src="' . asset('public/images/icon_detail.gif') . '" class="me-1" alt="image not found" style="width: 20px; height: 20px;cursor: pointer;" onclick="window.location.href=\'' . route('products.show', $product->id) . '\'">',
                'check'        => '<input type="checkbox" class="form-check-input product_checkbox" value="' . $product->id . '" data-id="' . $product->id . '">',
            ];
        });
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data"            => $data,
        ]);
    }


    public function getSampleOrderList(Request $request)
    {
        $query = Opportunity::query()
            ->join('sample_orders', 'sample_orders.opportunity_id', '=', 'opportunities.id')
            ->with(['customer', 'location', 'primary_user', 'secondary_user'])
            ->select('opportunities.id as opportunity_id', 'opportunities.created_at as date', 'sample_orders.id as sample_order_id', 'opportunities.*')
            ->groupBy('opportunities.id')
            ->orderBy('opportunities.created_at', 'asc');
        return $query;
    }

    public function dataTableSampleOrder(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName  = 'date';
        $vendorTypes = $this->getSampleOrderList($request);
        $total       = $vendorTypes->count();

        $totalFilter = $this->getSampleOrderList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSampleOrderList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            // Add a unique ID for the row using a data-id attribute
            $value->DT_RowAttr = [
                'data-id' => $value->opportunity_id
            ];
            $value->date_time = "<a href='javascript:void(0);' class='text-secondary open-modal-btn' style='font-size:8pt;' data-bs-toggle='modal'data-bs-target='#searchListSampleOrderModel' data-bs-id=" . $value->opportunity_id . ">" . ($value->opportunity_code ?? '') . " " . \Carbon\Carbon::parse($value->date)->format('M d, Y, h:i A') . "</a>";
            $value->opportunity = $value->opportunity_id ?? '';
            $value->job_name = "<div style='font-size:8pt;'><span>" . ($value->ship_to_job_name ?? '') . "</span><span>" . ($value->ship_to_address ?? '') . "</span><span>" . ($value->ship_to_zip ?? '') . "</span><span>P: " . ($value->ship_to_phone ?? '') . "</span></div>";
            $value->bill_customer = $value->customer->customer_name ?? '';
            $value->company = $value->location->company_name ?? 'N/A';
            $value->sales_person = "<a href='" . route('opportunities.show', $value->id) . "' class='text-secondary'><ul style='list-style-type: none; padding: 0; margin: 0;'>" .
                (!empty($value->primary_user?->first_name) ? "<li><img src='" . asset('public/images/PrimSales.png') . "' alt='primary person'> " . e($value->primary_user->first_name) . "</li>" : "") .
                (!empty($value->secondary_user?->first_name) ? "<li><img src='" . asset('public/images/SecSales.png') . "' alt='secondary person'> " . e($value->secondary_user->first_name) . "</li>" : "") . "</ul></a>";
            $value->notes = "<a href='javascript:void(0);' class='text-secondary' style='display: block; margin-bottom: 10px;'><div style='display: flex; align-items: center; gap: 10px;'>" . (!empty($value->internal_notes) ? "<i class='fi fi-rr-note-sticky text-dark fw-bold fs-3' data-bs-toggle='tooltip' data-bs-placement='top' title='Internal Notes: " . htmlspecialchars($value->internal_notes, ENT_QUOTES, 'UTF-8') . "'></i>" : "") . "</div></a>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getSampleOrderAllList(Request $request, $id)
    {
        return SampleOrder::where('opportunity_id', $id);
    }

    public function dataTableSampleOrderAll(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName  = 'created_at';
        $vendorTypes = $this->getSampleOrderAllList($request, $id);
        $total       = $vendorTypes->count();

        $totalFilter = $this->getSampleOrderAllList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSampleOrderAllList($request, $id);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->skip($start)->take($rowPerPage)->get();
        // Add position for each visit
        $offset = $start + 1;
        $arrData->map(function ($value, $index) use ($offset) {
            $value->position = $offset + $index;
            $value->date_time = "<a href='" . route('create.sample_orders.show', $value->id) . "' class='text-secondary' style='font-size:8pt;'>" . \Carbon\Carbon::parse($value->created_at)->format('M d, Y, h:i A') . "</a>";
            $value->sample_order = $value->opportunity_id . '-' . $value->position ?? '';
            $value->sample_order_label = $value->sample_order_label ?? '';
            $value->status = '<div class="progress mb-3">
                    <div
                      class="progress-bar bg-primary shadow-none"
                      role="progressbar"
                      style="width: 25%"
                      aria-valuenow="15"
                      aria-valuemin="0"
                      aria-valuemax="100"></div>
                    <div
                      class="progress-bar bg-success shadow-none"
                      role="progressbar"
                      style="width: 25%"
                      aria-valuenow="30"
                      aria-valuemin="0"
                      aria-valuemax="100"></div>
                    <div
                      class="progress-bar bg-danger shadow-none"
                      role="progressbar"
                      style="width: 25%"
                      aria-valuenow="20"
                      aria-valuemin="0"
                      aria-valuemax="100"></div>
                    <div
                      class="progress-bar bg-danger shadow-none"
                      role="progressbar"
                      style="width: 25%"
                      aria-valuenow="20"
                      aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>';
            $value->help_cust = "<a href='" . route('visits.edit_visit_product', $value->id) . "' class='btn btn-dark' style='font-size:8pt;'>Help Cust.</a>";
            $createdAt = \Carbon\Carbon::parse($value->created_at);
            $value->day = 1;
            $value->total = $value->total ?? '';
            $value->printed_notes = "<a href='" . route('visits.show', $value->id) . "' class='text-secondary' style='display: block; margin-bottom: 10px;'>" . "<div style='display: flex; align-items: center; gap: 10px;'>" . (!empty($value->sample_order_printed_notes) ? "<i class='fi fi-rr-note-sticky text-dark fw-bold fs-3' data-bs-toggle='tooltip' data-bs-placement='top' title='Printed Notes: " . htmlspecialchars($value->sample_order_printed_notes, ENT_QUOTES, 'UTF-8') . "'></i>" : "") . "</div></a>";
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item editbtn text-success' href='" . route('create.sample_orders.edit', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-edit-alt me-1 icon-success'></i> Edit</a></div></div>";
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
