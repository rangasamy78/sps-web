<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\VendorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\VendorTypeRepository;
use App\Http\Requests\VendorType\{CreateVendorTypeRequest, UpdateVendorTypeRequest};

class VendorTypeController extends Controller
{
    private VendorTypeRepository $vendorTypeRepository;

    public function __construct(VendorTypeRepository $vendorTypeRepository)
    {
        $this->vendorTypeRepository = $vendorTypeRepository;
    }

    public function index()
    {
        return view('vendor_type.vendor_types');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateVendorTypeRequest $request)
    {
        try {
            $this->vendorTypeRepository->store($request->only('vendor_type_name'));
            return response()->json(['status' => 'success', 'msg' => 'Vendor Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Vendor Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Vendor Type.']);
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
        $model = $this->vendorTypeRepository->findOrFail($id);
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
        $model = $this->vendorTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVendorTypeRequest $request, VendorType $vendorType)
    {
        try {
            $vendorType->update($request->only('vendor_type_name')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Vendor Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Vendor Type: ' . $e->getMessage());
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
            $this->vendorTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Vendor Type deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Vendor Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the department.']);
        }
    }

    public function getVendorTypeDataTableList(Request $request) {
        return $this->vendorTypeRepository->dataTable($request);
    }
}