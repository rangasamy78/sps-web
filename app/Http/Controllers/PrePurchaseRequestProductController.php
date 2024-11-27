<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PrePurchaseRequestProduct;
use App\Repositories\PrePurchaseRequestProductRepository;
use App\Services\PrePurchaseRequest\PrePurchaseRequestService;
use App\Http\Requests\PrePurchaseRequestProduct\{CreatePrePurchaseRequestProductRequest, UpdatePrePurchaseRequestProductRequest};

class PrePurchaseRequestProductController extends Controller
{
    public $prePurchaseRequestService;
    public $prePurchaseRequestProductRepository;

    public function __construct(PrePurchaseRequestProductRepository $prePurchaseRequestProductRepository, PrePurchaseRequestService $prePurchaseRequestService)
    {
        $this->prePurchaseRequestService           = $prePurchaseRequestService;
        $this->prePurchaseRequestProductRepository = $prePurchaseRequestProductRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrePurchaseRequestProductRequest $request)
    {
        try {
            $this->prePurchaseRequestProductRepository->store($request->only('s_no','product_id','supplier_id','pre_purchase_request_id','product_sku','avg_est_cost','description','purchasing_note','pur_qty','pur_uom_id','length','width','picking_qty','picking_unit','slab','qty'));
            return response()->json(['status' => 'success', 'msg' => 'Product saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Product.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->prePurchaseRequestProductRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->prePurchaseRequestProductRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrePurchaseRequestProductRequest $request, PrePurchaseRequestProduct $prePurchaseRequestProduct)
    {
        try {
            $this->prePurchaseRequestProductRepository->update($request->only('s_no','product_id','supplier_id','pre_purchase_request_id','product_sku','avg_est_cost','description','purchasing_note','pur_qty','pur_uom_id','length','width','picking_qty','picking_unit','slab','qty','response_qty','unit_price','total_price','requested_product'), $prePurchaseRequestProduct->id);
            return response()->json(['status' => 'success', 'msg' => 'Product updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Product : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Product .']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $prePurchaseRequestProduct = $this->prePurchaseRequestProductRepository->findOrFail($id);
            if ($prePurchaseRequestProduct) {
                $this->prePurchaseRequestProductRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Product not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Product : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Product .']);
        }
    }

    public function getPrePurchaseRequestProductDataTableList(Request $request) {
        return $this->prePurchaseRequestProductRepository->dataTable($request);
    }

    public function getPrePurchaseRequestProductDetails(Request $request)
    {
        $contactId = $request->query('id');
        $address   = $this->prePurchaseRequestService->getPrePurchaseRequestProductDetails($contactId);

        if (isset($address['error'])) {
            return response()->json(['status' => 'false', 'error' => $address['error']]);
        }

        return response()->json(['status' => 'success', 'data' => $address]);
    }
}
