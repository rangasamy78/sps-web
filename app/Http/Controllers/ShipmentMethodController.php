<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\ShipmentMethod;
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
            return response()->json(['status' => 'success', 'msg' => 'Shipment method saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Shipment method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Shipment method.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Shipment method updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Shipment method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Shipment method.']);
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
            $shipmentMethod = $this->shipmentMethodRepository->findOrFail($id);
            if ($shipmentMethod) {
                $this->shipmentMethodRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Shipment method deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Shipment method not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Shipment method: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Shipment method.']);
        }
    }

    public function getShipmentMethodDataTableList(Request $request) {
        return $this->shipmentMethodRepository->dataTable($request);
    }

}
