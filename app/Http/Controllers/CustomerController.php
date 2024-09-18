<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\CustomerRepository;
use App\Http\Requests\Customer\{CreateCustomerRequest, UpdateCustomerRequest};

class CustomerController extends Controller
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        return view('customer.customers');
    }

    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        try {
            $this->customerRepository->store($request->only('customer_name'));
            return response()->json(['status' => 'success', 'msg' => 'Customer saved successfully.'], 200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving customer: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while saving the customer.'], 500);
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
        $model = $this->customerRepository->findOrFail($id);
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
        $model = $this->customerRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            $this->customerRepository->update($request->only('customer_name'), $customer->id);
            return response()->json(['status' => 'success', 'msg' => 'Customer updated successfully.'],200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating customer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the customer.'],500);
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
            $customer = $this->customerRepository->findOrFail($id);
            if ($customer) {
                $this->customerRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Customer deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Customer not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting customer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the customer.']);
        }

    }

    public function getCustomerDataTableList(Request $request)
    {
        return $this->customerRepository->dataTable($request);
    }

}
