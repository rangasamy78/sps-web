<?php

namespace App\Repositories\Quote\Lines;

use App\Models\QuoteProduct;
use App\Models\Product;
use App\Models\QuoteReceiveDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteProductRepository
{
    public function findOrFail(int $id)
    {
        return QuoteProduct::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return QuoteProduct::create($data);
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
        $query = QuoteProduct::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
    }

    public function getQuoteProductServiceList(Request $request, $id)
    {
        $queryProduct = DB::table('quote_products')
            ->join('products', 'products.id', '=', 'quote_products.product_id')
            ->join('unit_measures', 'unit_measures.id', '=', 'products.unit_of_measure_id')
            ->where('quote_products.quote_id', $id)
            ->select(
                'products.product_name as name',
                'unit_measures.unit_measure_name as unit_measure_name',
                'products.product_sku as sku',
                'quote_products.id as id',
                'quote_products.product_id as line_id',
                'quote_products.description as description',
                'quote_products.is_sold_as as is_sold_as',
                'quote_products.product_quantity as quantity',
                'quote_products.product_unit_price as unit_price',
                'quote_products.product_amount as amount',
                'quote_products.is_tax as tax',
                'quote_products.is_hide_line as is_hide_line',
                'quote_products.inventory_restriction as restriction',
                'quote_products.created_at as created_at',
                DB::raw("'product' as type")
            );

        $queryService = DB::table('quote_services')
            ->join('services', 'services.id', '=', 'quote_services.service_id')
            ->join('unit_measures', 'unit_measures.id', '=', 'services.unit_of_measure_id')
            ->where('quote_services.quote_id', $id)
            ->select(
                'services.service_name as name',
                'unit_measures.unit_measure_name as unit_measure_name',
                'services.service_sku as sku',
                'quote_services.id as id',
                'quote_services.service_id as line_id',
                'quote_services.description as description',
                'quote_services.is_sold_as as is_sold_as',
                'quote_services.service_quantity as quantity',
                'quote_services.service_unit_price as unit_price',
                'quote_services.service_amount as amount',
                'quote_services.is_tax as tax',
                'quote_services.is_hide_line as is_hide_line',
                DB::raw('NULL as restriction'),
                'quote_services.created_at as created_at',
                DB::raw("'service' as type")
            );
        $combinedQuery = $queryProduct->unionAll($queryService);
        return $combinedQuery;
    }

    public function getDepositAmount($quoteId)
    {
        return QuoteReceiveDeposit::select('id', 'quote_id', 'receive_amount', 'payment_method_id')
            ->with(['payment_method:id,payment_method_name'])
            ->where('quote_id', $quoteId)
            ->get()
            ->map(function ($deposit) {
                return [
                    'id' => $deposit->id,
                    'quote_id' => $deposit->quote_id,
                    'receive_amount' => $deposit->receive_amount ?? 0,
                    'payment_method' => $deposit->payment_method->payment_method_name ?? '',
                ];
            });
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
        $aboutUsOptions = $this->getQuoteProductServiceList($request, $id);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getQuoteProductServiceList($request, $id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getQuoteProductServiceList($request, $id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->qty = $value->quantity ?? 0;
            $value->product_name = $value->name ?? '';
            $value->name = '<span class="product-name">' . ($value->name ?? '') . '</span>' .
                (isset($value->restriction)
                    ? '<div class="text-dark">Restriction: ' . $value->restriction . '</div>'
                    : '');
            $value->sku = $value->sku ?? '';
            $value->description = $value->description ?? '';
            $value->quantity = $value->quantity . ' ' . $value->unit_measure_name ?? '';
            $value->unit_price = $value->unit_price ?? '';
            $value->amount = $value->amount ?? '';
            $value->tax_cal = $value->tax;
            $value->tax = ($value->tax == 1
                ? "<i class='fi fi-rr-circle-y text-dark fw-bold'></i>"
                : "<i class='fi fi-rr-circle-n text-dark fw-bold'></i>")
                . "<input type='hidden' readonly class='border-0 text-secondary tax' value='" . ($value->tax ?? '') . "'>";
            $value->fullfiled = '';
            $value->balance = $value->quantity  ?? '';
            $value->hide_line = $value->is_hide_line == 1
                ? "<i class='fi fi-rr-eye-crossed'></i>"
                : '';
            $value->action = "<div class='dropup'>
                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                    <i class='bx bx-dots-vertical-rounded icon-color'></i>
                </button>
                <div class='dropdown-menu'>";
            // Check if the row is a product or service
            if ($value->type === 'product') {
                $value->action .= "<a class='dropdown-item updateQuoteItemContact text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}'><i class='bx bx-edit-alt me-1 icon-success'></i> Update Item</a>";
                $value->action .= "<a class='dropdown-item deleteQuoteProduct text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}'><i class='bx bx-trash me-1 icon-danger'></i> Delete Line</a>";
                $value->action .= "<a class='dropdown-item productPriceCalculator text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}' data-name=' $value->product_name 'data-quantity='{$value->qty}' data-uom='$value->unit_measure_name'><i class='bx bx-dollar'></i> Price Calculator From Cost</a>";
                $value->action .= "<a class='dropdown-item addOptionLineProduct text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}' data-name=' $value->product_name '><i class='fi fi-rr-plus'></i> Add Option Line</a>";
                $value->action .= "<a class='dropdown-item setupNewContactBtn text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}' data-bs-toggle='offcanvas' data-bs-target='#itemOffcanvas'><i class='fi fi-rr-square-plus'></i> Add Item</a>";
                $value->action .= "<a class='dropdown-item setupNewContactBtn text-dark fw-bold href='javascript:void(0);' data-id='{$value->id}' data-bs-toggle='offcanvas' data-bs-target='#serviceOffcanvas'><i class='fi fi-rr-add-document'></i> Add Service</a>";
                $value->action .= "<a class='dropdown-item setupNewContactBtn text-dark fw-bold' href='" . route('products.show', $value->line_id) . "' data-id='{$value->id}' ><i class='fi fi-rr-box-open'></i> Goto item Detail</a>";
            } elseif ($value->type === 'service') {
                $value->action .= "<a class='dropdown-item updateQuoteServiceContact text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}'><i class='fi fi-rr-file-edit'></i> Update Service</a>";
                $value->action .= "<a class='dropdown-item deleteQuoteService text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}' ><i class='bx bx-trash me-1 icon-danger'></i> Delete Service Line</a>";
                $value->action .= "<a class='dropdown-item addOptionLineService text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}' data-name=' $value->product_name '><i class='fi fi-rr-plus'></i> Service Add Option Line</a>";
                $value->action .= "<a class='dropdown-item setupNewContactBtn text-dark fw-bold' href='javascript:void(0);' data-id='{$value->id}' data-bs-toggle='offcanvas' data-bs-target='#itemOffcanvas'><i class='fi fi-rr-square-plus'></i> Add Item</a>";
                $value->action .= "<a class='dropdown-item setupNewContactBtn text-dark fw-bold href='javascript:void(0);' data-id='{$value->id}' data-bs-toggle='offcanvas' data-bs-target='#serviceOffcanvas'><i class='fi fi-rr-add-document'></i> Add Service</a>";
                $value->action .= "<a class='dropdown-item setupNewContactBtn text-dark fw-bold' href='" . route('services.show', $value->line_id) . "' data-id='{$value->id}' ><i class='fi fi-rr-box-open'></i> Goto Service Details</a>";
            }
            $value->action .= "</div></div>";
            return $value;
        });
        $deposit = $this->getDepositAmount($id);
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
            "data2"        => $deposit,
        );
        return response()->json($response);
    }

    public function getProductList(Request $request)
    {
        $query = Product::with('product_type')
            ->join('product_price', 'product_price.product_id', '=', 'products.id')
            ->select('products.*', 'product_price.*');
        if (!empty($request->productName)) {
            $query->where('product_name', 'like', '%' . $request->productName . '%');
        }
        if (!empty($request->productCode)) {
            $query->where('product_sku', 'like', '%' . $request->productCode . '%');
        }
        return $query;
    }

    public function dataTableGetProduct(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName     = 'products.created_at';
        $aboutUsOptions = $this->getProductList($request);
        $total          = $aboutUsOptions->count();

        $totalFilter = $this->getProductList($request);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getProductList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->id = $value->id ?? '';
            $value->product_name = $value->product_name ?? '';
            $value->product_sku = $value->product_sku ?? '';
            $value->type = $value->product_type->product_type ?? '';
            $value->homeowner_price = $value->homeowner_price ?? '';
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
