<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\SupplierPort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\{ SupplierPortRepository, DropDownRepository };
use App\Http\Requests\SupplierPort\{CreateSupplierPortRequest, UpdateSupplierPortRequest};
use App\Models\Country;

class SupplierPortController extends Controller
{
    public SupplierPortRepository $supplierPortRepository;
    public DropDownRepository $dropDownRepository;

    public function __construct(SupplierPortRepository $supplierPortRepository, DropDownRepository $dropDownRepository)
    {
        $this->supplierPortRepository = $supplierPortRepository;
        $this->dropDownRepository = $dropDownRepository;
    }

    public function index()
    {
        $countries = $this->dropDownRepository->dropDownPopulate('countries');
        return view('supplier_port.supplier_ports', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierPortRequest $request)
    {
        try {
            $this->supplierPortRepository->store($request->only('supplier_port_name','avg_days','country_id'));
            return response()->json(['status' => 'success', 'msg' => 'Supplier Port saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Supplier Port: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier Port.']);
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
        $countries = $this->dropDownRepository->dropDownPopulate('countries');
        $model = $this->supplierPortRepository->findOrFail($id);
        return response()->json(compact('model', 'countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->supplierPortRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierPortRequest $request, SupplierPort $supplierPort)
    {
        try {
            $supplierPort->update($request->only('supplier_port_name','avg_days','country_id')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Supplier Port updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Supplier Port: ' . $e->getMessage());
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
            $this->supplierPortRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Supplier Port deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Supplier Port: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the department.']);
        }
    }

    public function getSupplierPortDataTableList(Request $request) {
        return $this->supplierPortRepository->dataTable($request);
    }

}
