<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerImageRequest;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\AboutUsOption;
use App\Models\AccountPaymentTerm;
use App\Models\BinType;
use App\Models\Company;
use App\Models\Consignment;
use App\Models\Country;
use App\Models\County;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\EndUseSegment;
use App\Models\PriceListLabel;
use App\Models\ProjectType;
use App\Models\TaxExemptReason;
use App\Models\User;
use App\Repositories\CustomerRepository;
use App\Services\Customer\CustomerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public $customerService;
    public $customerRepository;

    public function __construct(CustomerRepository $customerRepository, CustomerService $customerService)
    {
        $this->customerService    = $customerService;
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customerTypes = CustomerType::query()->pluck('customer_type_name', 'id');
        $companies     = Company::query()->pluck('company_name', 'id');
        return view('customer.customers', compact('customerTypes', 'companies'));
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
        $query       = $this->customerRepository->buildBaseQuery();
        $customer    = $query->findOrFail($id);
        $countries   = Country::query()->pluck('country_name', 'id');
        $counties    = County::query()->pluck('county_name', 'id');
        $consignment = Consignment::query()->pluck('consignment_location_id', 'id');
        $binTypes    = BinType::query()->pluck('bin_type', 'id');

        return view('customer.show', compact('customer', 'countries', 'counties', 'consignment', 'binTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data     = $this->__getDropDownData();
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
            return response()->json(['status' => 'success', 'msg' => 'Customer updated successfully.'], 200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating customer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the customer.'], 500);
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
                if ($customer->status == 0) {
                    return response()->json(['status' => 'false', 'msg' => 'Customer is already inactive.']);
                }
                $customer->status = 0;
                $customer->save();
                return response()->json(['status' => 'success', 'msg' => 'Customer marked as inactive.']);
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
        $customerId = $request->query('id');
        $address    = $this->customerService->getBillingAddress($customerId);

        if (isset($address['error'])) {
            return response()->json(['error' => $address['error']], 404);
        }

        return response()->json($address);
    }

    private function __getDropDownData($customer = null)
    {
        $countries           = Country::query()->pluck('country_name', 'id');
        $customers           = Customer::query()->pluck('customer_name', 'id');
        $customerTypes       = CustomerType::query()->pluck('customer_type_name', 'id');
        $companies           = Company::query()->pluck('company_name', 'id');
        $users               = User::query()->select(DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'id')->get()->pluck('name', 'id');
        $counties            = County::query()->pluck('county_name', 'id');
        $priceListLabels     = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        $taxExemptReasons    = TaxExemptReason::query()->pluck('reason', 'id');
        $aboutUsOptions      = AboutUsOption::query()->pluck('how_did_you_hear_option', 'id');
        $projectTypes        = ProjectType::query()->pluck('project_type_name', 'id');
        $endUseSegments      = EndUseSegment::query()->pluck('end_use_segment', 'id');
        $accountPaymentTerms = AccountPaymentTerm::query()->pluck('payment_label', 'id');
        $salesTaxs           = DB::table('tax_codes')->join('tax_code_components', 'tax_codes.id', '=', 'tax_code_components.tax_code_id')
            ->select('tax_codes.id', DB::raw("CONCAT(tax_codes.tax_code, ' - ', tax_codes.tax_code_label, ' - ', SUM(tax_code_components.rate), ' %') as name"))
            ->groupBy('tax_codes.id')
            ->get()->pluck('name', 'id');
        return compact('countries', 'customers', 'customerTypes', 'customer', 'companies', 'users', 'counties', 'priceListLabels', 'taxExemptReasons', 'aboutUsOptions', 'projectTypes', 'endUseSegments', 'accountPaymentTerms', 'salesTaxs');
    }

    public function customerUploadImage(CreateCustomerImageRequest $request)
    {
        if ($request->hasFile('customer_image')) {
            $this->customerRepository->updateImage($request->only('customer_image'), $request->id);
            return response()->json(['status' => 'success', 'msg' => 'Image uploaded successfully']);
        }
        return response()->json(['status' => 'false', 'msg' => 'Image upload failed.'], 400);
    }

    public function updateStatus($id)
    {
        try {
            $customer         = $this->customerRepository->findOrFail($id);
            $update_status    = $customer->status == 1 ? 0 : 1;
            $customer->status = $update_status;
            $customer->save();

            return response()->json([
                'status'        => 'success',
                'update_status' => $update_status,
                'msg'           => 'Status updated successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg'    => 'Failed to update status.',
            ], 500);
        }
    }
}
