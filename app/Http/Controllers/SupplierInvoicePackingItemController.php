<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\BinType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseOrderProduct;
use App\Models\SupplierInvoicePackingItem;
use App\Services\SupplierInvoicePackingItem\SupplierInvoicePackingItemService;
use App\Http\Requests\SupplierInvoicePackingItem\{ CreateSupplierInvoicePackingItemRequest, UpdateSupplierInvoicePackingItemRequest};

class SupplierInvoicePackingItemController extends Controller
{
    public $supplierInvoicePackingItemService;

    public function __construct( SupplierInvoicePackingItemService $supplierInvoicePackingItemService)
    {
        $this->supplierInvoicePackingItemService = $supplierInvoicePackingItemService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $binTypes   = BinType::query()->pluck('bin_type', 'id');
        $poProducts = PurchaseOrderProduct::query()->where('po_id', $request->po_id) ->with(['product'])->get();
        $products = [];
        if($poProducts->isNotEmpty()){
            $products = $poProducts->map(fn($product) => array_merge(
                $product->only(['id', 'po_id', 'product_id']),
                [
                    'isSeqBlock' => PurchaseOrderProduct::IS_SEQ_BLOCK,
                    'isSeqBundle' => PurchaseOrderProduct::IS_SEQ_BUNDLE,
                    'isSeqSupplier' => PurchaseOrderProduct::IS_SEQ_SUPPLIER,
                ]
            ))->toArray();
        }
        return view('supplier_invoice.packing_items', compact('poProducts','binTypes','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
            list($supplierInvoiceItem, $productId, $maxSerialNo, $maxLotBlock, $maxBundle, $maxSupplierRef) = $this->supplierInvoicePackingItemService->getSupplierInvoiceAddPackingItem( $request->all());
            return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice Packing Item saved successfully.', 'data' => $supplierInvoiceItem, 'product_id' => $productId,
            'max_serial_no' => $maxSerialNo, 'max_lot_block' => $maxLotBlock, 'max_bundle' => $maxBundle, 'max_supplier_ref' => $maxSupplierRef]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving company: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the company.']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = $this->supplierInvoicePackingItemService->findOrFail($id);
        $records = '';
        if($model){
            list($productId, $poId) = array_values($model->only('product_id', 'po_id'));
            $records = PurchaseOrderProduct::query()->where('po_id', $poId)->where('product_id',$productId)->first()->unit_price;
        }
        return response()->json(['data' => $model, 'unit_price' => $records]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        try {
            list( $supplierInvoiceItem ) = $this->supplierInvoicePackingItemService->getSupplierInvoiceEditPackingItem($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice Packing Item updated successfully.', 'data' => $supplierInvoiceItem]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Supplier Invoice Packing Item: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Supplier Invoice Packing Item.']);
        }
    }

    public function updateMultiple(Request $request)
    {
        try {
            list($supplierInvoiceItem, $productId, $maxSerialNo, $maxLotBlock, $maxBundle, $maxSupplierRef) = $this->supplierInvoicePackingItemService->getSupplierInvoiceUpdatePackingItem( $request->all());
            return response()->json(['status' => 'success', 'msg' => 'Supplier Invoice Packing Item saved successfully.', 'data' => $supplierInvoiceItem, 'product_id' => $productId,
            'max_serial_no' => $maxSerialNo, 'max_lot_block' => $maxLotBlock, 'max_bundle' => $maxBundle, 'max_supplier_ref' => $maxSupplierRef]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Supplier Invoice Packing Item: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Invoice Packing Item.']);
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->supplierInvoicePackingItemService->findOrFail($id);
            if ($product) {
                $response = $this->supplierInvoicePackingItemService->delete($id);
                $data = $response->getData();
                if ($data->status == 'success') {
                    return response()->json(['status' => $data->status, 'msg' => $data->msg]);
                } else if ($data->status == 'error') {
                    return response()->json(['status' => $data->status, 'msg' => $data->msg]);
                }
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product deleted successfully.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting product : ' . $e->getMessage());
            return response()->json(['status' => $data->status, 'msg' => $data->msg], 500);
        }
        return $response;
    }

    public function deleteMultiple(Request $request)
    {
        $itemIds = $request->input('item_ids');
        if (!$itemIds || !is_array($itemIds)) {
            return response()->json([ 'status' => 'error', 'msg' => 'Invalid item IDs.',], 400);
        }
        try {
            SupplierInvoicePackingItem::whereIn('id', $itemIds)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Selected items deleted successfully.',]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Failed to delete items. Please try again.',], 500);
        }
    }

    public function fetchProductsAll(Request $request)
    {
       try {
            $products = $this->supplierInvoicePackingItemService->getSupplierInvoicePackingItemFetchAll( $request->all());
            return response()->json(['status' => 'success', 'data' => $products]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving sipl: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the sipl.']);
        }

    }

    public function updateNote(Request $request)
    {
        try {
            $this->supplierInvoicePackingItemService->updateNote( $request->all());
            return response()->json(['status' => 'success', 'msg' => 'Note updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the note.']);
        }
    }

    public function getAssignSlabMultiple(Request $request){
        try {
            list( $records, $selectedItemIds ) = $this->supplierInvoicePackingItemService->updateAssignSlabMultiple( $request->all());
            return response()->json(['status' => 'success', 'data' => $records, 'selectItems' => $selectedItemIds]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the note.']);
        }
    }

    public function getUpdateSlabMultiple(Request $request){
        try {
            $this->supplierInvoicePackingItemService->updateSlabItemMultiple( $request->only('product_id','items'));
            return response()->json(['status' => 'success', 'msg' => 'Note updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving note: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the note.']);
        }
    }
}
