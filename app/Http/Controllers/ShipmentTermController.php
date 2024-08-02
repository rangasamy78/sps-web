<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\ShipmentTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ShipmentTermRepository;
use App\Http\Requests\ShipmentTerm\{CreateShipmentTermRequest, UpdateShipmentTermRequest};
class ShipmentTermController extends Controller
{
    private ShipmentTermRepository $shipmentTermRepository;

    public function __construct(ShipmentTermRepository $shipmentTermRepository)
    {
        $this->shipmentTermRepository = $shipmentTermRepository;
    }

    public function index()
    {
        return view('shipment_term.shipment_terms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateShipmentTermRequest $request)
    {
        try {
            $this->shipmentTermRepository->store($request->only('shipment_term_name','description'));
            return response()->json(['status' => 'success', 'msg' => 'Shipment Term saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Shipment Term: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Shipment Term.']);
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
        $model = $this->shipmentTermRepository->findOrFail($id);
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
        $model = $this->shipmentTermRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShipmentTermRequest $request, ShipmentTerm $shipmentTerm)
    {
        try {
            $this->shipmentTermRepository->update($request->only('shipment_term_name','description'),$shipmentTerm->id); 
            return response()->json(['status' => 'success', 'msg' => 'Shipment Term updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Shipment Term: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Shipment Term.']);
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
            $this->shipmentTermRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Shipment Term deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Shipment Term: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Shipment Term.']);
        }
    }

    public function getShipmentTermDataTableList(Request $request) {
        return $this->shipmentTermRepository->dataTable($request);
    }
}
