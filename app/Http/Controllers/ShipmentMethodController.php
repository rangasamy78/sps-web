<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\ShipmentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ShipmentMethodRepository;
use App\Http\Requests\ShipmentMethod\{CreateShipmentMethodRequest, UpdateShipmentMethodRequest};

class ShipmentMethodController extends Controller
{
    private ShipmentMethodRepository $shipmentMethodRepository;

    public function __construct(ShipmentMethodRepository $shipmentMethodRepository)
    {
        $this->shipmentMethodRepository = $shipmentMethodRepository;
    }

    public function index()
    {
        return view('shipment_method.shipment_methods');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateShipmentMethodRequest $request)
    {
        try {
            $this->shipmentMethodRepository->store($request->only('shipment_method_name'));
            return response()->json(['status' => 'success', 'msg' => 'Shipment Method saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Shipment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Shipment Method.']);
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
        $model = $this->shipmentMethodRepository->findOrFail($id);
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
        $model = $this->shipmentMethodRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShipmentMethodRequest $request, ShipmentMethod $shipmentMethod)
    {
        try {
            $shipmentMethod->update($request->only('shipment_method_name')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Shipment Method updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Shipment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the department.']);
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
            $this->shipmentMethodRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Shipment Method deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Shipment Method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the department.']);
        }
    }

    public function getShipmentMethodDataTableList(Request $request) {
        return $this->shipmentMethodRepository->dataTable($request);
    }

}
