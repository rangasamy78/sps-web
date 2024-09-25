<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use App\Models\County;
use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\ProjectType;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Models\AboutUsOption;
use App\Models\EndUseSegment;
use App\Models\PriceListLabel;
use App\Models\TaxExemptReason;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\CustomerRepository;
use App\Services\Customer\CustomerService;
use App\Http\Requests\Customer\{CreateCustomerRequest, UpdateCustomerRequest};
class CustomerController extends Controller
{
    public $customerService;
    public $customerRepository;

    public function __construct(CustomerRepository $customerRepository, CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customerTypes = CustomerType::query()->pluck('customer_type_name', 'id');
        $companies = Company::query()->pluck('company_name', 'id');
        return view('customer.customers', compact('customerTypes','companies'));
    }

    public function create()
    {
        $data = $this->__getDropDownData();
        return view('customer.create', compact('data'));
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
            $this->customerRepository->store($request->all());
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
        $query = $this->customerRepository->buildBaseQuery();
        $customer = $query->findOrFail($id);
        // return response()->json($model);
        return view('customer.details', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->__getDropDownData();
        $customer = $this->customerRepository->findOrFail($id);
        return view('customer.edit', ['customer' => $customer, 'data' => $data]);
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
            $this->customerRepository->update($request->all(), $customer->id);
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

    public function fetchCustomerBillingAddress(Request $request)
    {
        $customerId = $request->query('id');  // Or use $request->input('id') based on your needs
        $address = $this->customerService->getBillingAddress($customerId);

        if (isset($address['error'])) {
            return response()->json(['error' => $address['error']], 404);
        }

        return response()->json($address);
    }

    private function __getDropDownData($customer = null)
    {
        $countries = Country::query()->pluck('country_name', 'id');
        $customers = Customer::query()->pluck('customer_name', 'id');
        $customerTypes = CustomerType::query()->pluck('customer_type_name', 'id');
        $companies = Company::query()->pluck('company_name', 'id');
        $users = User::query()->pluck('name', 'id');
        $counties = County::query()->pluck('county_name', 'id');
        $priceListLabels = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        $taxExemptReasons = TaxExemptReason::query()->pluck('reason', 'id');
        $aboutUsOptions = AboutUsOption::query()->pluck('how_did_you_hear_option', 'id');
        $projectTypes = ProjectType::query()->pluck('project_type_name', 'id');
        $endUseSegments = EndUseSegment::query()->pluck('end_use_segment', 'id');
        $accountPaymentTerms = AccountPaymentTerm::query()->pluck('payment_label', 'id');
        return compact('countries', 'customers', 'customerTypes', 'customer', 'companies','users','counties', 'priceListLabels','taxExemptReasons','aboutUsOptions','projectTypes','endUseSegments','accountPaymentTerms');
    }

    public function customerUploadImage(Request $request)
    {
        if ($request->hasFile('customer_image')) {
            $this->customerRepository->updateImage($request->only('customer_image'), $request->id);
            return response()->json(['status' => 'success', 'msg' => 'Image uploaded successfully']);
        }
        return response()->json(['status' => 'false', 'msg' => 'Image upload failed.'],400);
    }
}
