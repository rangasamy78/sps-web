<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Product;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CrudRepositoryInterface;

class VisitRepository implements CrudRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Visit::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return Visit::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = Visit::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getProductVisitList($request, $id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('Visit ID is required');
        }
        $productQuery = DB::table('visit_products')
            ->join('products', 'visit_products.product_id', '=', 'products.id')
            ->where('visit_id', $id)
            ->select('visit_id as id', 'products.product_name as item_name', 'product_quantity as quantity', 'product_unit_price as unit_price', 'product_amount as amount', 'is_tax as tax', 'product_description as description', DB::raw("'product' as type"));

        $serviceQuery = DB::table('visit_services')
            ->join('services', 'visit_services.service_id', '=', 'services.id')
            ->where('visit_id', $id)
            ->select('visit_id as id', 'services.service_name as item_name', 'service_quantity as quantity', 'service_unit_price as unit_price', 'service_amount as amount', 'is_tax as tax', 'service_description as description', DB::raw("'service' as type"));

        $query = $productQuery
            ->unionAll($serviceQuery);
        return $query;
    }

    public function dataTable(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? 0;
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'quantity';
        $columnSortOrder = $orderArray[0]['dir'] ?? 'asc';
        $query = $this->getProductVisitList($request, $id);
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
            $value->item_name      = $value->item_name ?? '';
            $value->current_qty  = 0;
            $value->tax = ($value->tax == 1 ? "<i class='fi fi-rr-circle-y text-dark fw-bold'></i>" : "<i class='fi fi-rr-circle-n text-dark fw-bold'></i>") . "<input type='hidden' readonly class='border-0 text-secondary tax' value='" . ($value->tax ?? '') . "'>";
            $value->slab         = '';
            $value->serialNum    = '';
            $value->location     = '';
            $value->barcode      = '';
            $value->lot          = '';
            $value->bundle       = '';
            $value->supp_ref     = '';
            $value->quantity     = $value->quantity ?? '';
            $value->unit_price = "<input type='hidden' readonly class='border-0 text-secondary unit-price' value='" . ($value->unit_price ?? '') . "'>" . ($value->unit_price ?? '');
            $value->amount       = $value->amount ?? '';
            $value->action       = "<a class='dropdown-item showbtn text-warning' href='" . route('visits.edit_visit_product', $value->id) . "' data-id='{$value->id}'><i class='bx bxs-edit'></i></a>";
        });
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data"            => $data,
        ]);
    }

    public function getVisitList(Request $request)
    {
        $query = Opportunity::query()
            ->join('visits', 'visits.opportunity_id', '=', 'opportunities.id')
            ->with(['customer', 'location', 'primary_user', 'secondary_user'])
            ->select('opportunities.id as opportunity_id', 'opportunities.created_at as date', 'visits.id as visit_id', 'opportunities.*')
            ->groupBy('opportunities.id')
            ->orderBy('opportunities.created_at', 'asc');
        return $query;
    }

    public function dataTableVisit(Request $request)
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
        $vendorTypes = $this->getVisitList($request);
        $total       = $vendorTypes->count();

        $totalFilter = $this->getVisitList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getVisitList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            // Add a unique ID for the row using a data-id attribute
            $value->DT_RowAttr = [
                'data-id' => $value->opportunity_id
            ];
            $value->date_time = "<a href='javascript:void(0);' class='text-secondary open-modal-btn' style='font-size:8pt;' data-bs-toggle='modal'data-bs-target='#searchListVisitModel' data-bs-id=" . $value->opportunity_id . ">" . ($value->opportunity_code ?? '') . " " . \Carbon\Carbon::parse($value->date)->format('M d, Y, h:i A') . "</a>";
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
    public function getVisitAllList(Request $request, $id)
    {
        return Visit::where('opportunity_id', $id);
    }

    public function dataTableVisitAll(Request $request, $id)
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
        $vendorTypes = $this->getVisitAllList($request, $id);
        $total       = $vendorTypes->count();

        $totalFilter = $this->getVisitAllList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getVisitAllList($request, $id);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->skip($start)->take($rowPerPage)->get();
        // Add position for each visit
        $offset = $start + 1;
        $arrData->map(function ($value, $index) use ($offset) {
            $value->position = $offset + $index;
            $value->date_time = "<a href='" . route('visits.show', $value->id) . "' class='text-secondary' style='font-size:8pt;'>" . \Carbon\Carbon::parse($value->created_at)->format('M d, Y, h:i A') . "</a>";
            $value->visit = $value->opportunity_id . '-' . $value->position ?? '';
            $value->visit_label = $value->visit_label ?? '';
            // $value->walk_in = '<img src="' . asset('public/images/Walkin_Small.png') . '" alt="Walk-in">';
            $value->helped_at = '';
            $value->help_cust = "<a href='" . route('visits.edit_visit_product', $value->id) . "' class='btn btn-dark' style='font-size:8pt;'>Help Cust.</a>";
            if ($value->checkout == 0) {
                $value->checkout = '<button type="button" class="btn btn-dark btn-sm" height="50px" style="font-size:8pt;" id="checkout" name="checkout" data-id=' . $value->id . '>Checkout & Email</button>';
            } else {
                $createdAt = \Carbon\Carbon::parse($value->created_at);
                $updatedAt = \Carbon\Carbon::parse($value->updated_at);
                $timeDifference = $updatedAt->diffForHumans($createdAt, true); // e.g., "2 hours 30 minutes"
                $createdTime = $createdAt->format('h:i A'); // e.g., "02:15 PM"
                $value->checkout = '<div style="font-size:8pt;"><span>' . $createdTime . '</span><br><span>' . $timeDifference . '  help</span><br></div>';
            }
            $value->printed_notes = "<a href='" . route('visits.show', $value->id) . "' class='text-secondary' style='display: block; margin-bottom: 10px;'>" . "<div style='display: flex; align-items: center; gap: 10px;'>" . (!empty($value->visit_printed_notes) ? "<i class='fi fi-rr-note-sticky text-dark fw-bold fs-3' data-bs-toggle='tooltip' data-bs-placement='top' title='" . htmlspecialchars($value->visit_printed_notes, ENT_QUOTES, 'UTF-8') . "'></i>" : "") . "</div></a>";
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item editbtn text-success' href='" . route('visits.edit', $value->id) . "' data-id='" . $value->id . "'><i class='bx bx-edit-alt me-1 icon-success'></i> Edit</a></div></div>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
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
}
