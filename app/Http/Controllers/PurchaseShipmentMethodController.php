<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseShipmentMethod;
use App\Repositories\PurchaseShipmentMethodRepository;
use App\Http\Requests\PurchaseShipmentMethod\{CreatePurchaseShipmentMethodRequest, UpdatePurchaseShipmentMethodRequest};


class PurchaseShipmentMethodController extends Controller
{
    private PurchaseShipmentMethodRepository $purchaseShipmentMethodRepository;

    public function __construct(PurchaseShipmentMethodRepository $purchaseShipmentMethodRepository)
    {
        $this->purchaseShipmentMethodRepository = $purchaseShipmentMethodRepository;
    }
    public function index()
    {
        return view('purchase_shipment_method.purchase_shipment_methods');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePurchaseShipmentMethodRequest $request)
    {
        try {
            $this->purchaseShipmentMethodRepository->store($request->only('shipment_method_name', 'shipment_method_description'));
            return response()->json(['status' => 'success', 'msg' => 'Purchase Shipment Method saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Purchase Shipment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Purchase Shipment Method.']);
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
        $model = $this->purchaseShipmentMethodRepository->findOrFail($id);
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
        $model = $this->purchaseShipmentMethodRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseShipmentMethodRequest $request, PurchaseShipmentMethod $purchaseShipmentMethod)
    {
        try {
            $this->purchaseShipmentMethodRepository->update($request->only('shipment_method_name', 'shipment_method_description'), $purchaseShipmentMethod->id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Purchase Shipment Method updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Purchase Shipment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Purchase Shipment Method.']);
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
            $this->purchaseShipmentMethodRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Purchase Shipment Method deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Purchase Shipment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Purchase Shipment Method.']);
        }
    }

    public function getPurchaseShipmentMethodDataTableList(Request $request)
    {
        return $this->purchaseShipmentMethodRepository->dataTable($request);
    }
}
