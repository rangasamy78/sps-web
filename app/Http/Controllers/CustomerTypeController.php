<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\CustomerTypeRepository;
use App\Http\Requests\CustomerType\{CreateCustomerTypeRequest, UpdateCustomerTypeRequest};

class CustomerTypeController extends Controller
{
    private CustomerTypeRepository $customerTypeRepository;

    public function __construct(CustomerTypeRepository $customerTypeRepository)
    {
        $this->customerTypeRepository = $customerTypeRepository;
    }

    public function index()
    {
        return view('customer_type.customer_types');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerTypeRequest $request)
    {
        try {
            $this->customerTypeRepository->store($request->only('customer_type_name','customer_type_code'));
            return response()->json(['status' => 'success', 'msg' => 'Customer Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Customer Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Customer Type.']);
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
        $model = $this->customerTypeRepository->findOrFail($id);
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
        $model = $this->customerTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerTypeRequest $request, CustomerType $customerType)
    {
        try {
            $customerType->update($request->only('customer_type_name','customer_type_code')); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Customer Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Customer Type: ' . $e->getMessage());
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
            $this->customerTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Customer Type deleted successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Customer Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the department.']);
        }
    }

    public function getCustomerTypeDataTableList(Request $request) {
        return $this->customerTypeRepository->dataTable($request);
    }

}