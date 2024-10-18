<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TaxCode;
use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Associate;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\Models\CustomerType;
use App\Models\PriceListLabel;
use App\Models\AccountPaymentTerm;
use App\Models\EndUseSegment;
use App\Models\ProjectType;
use App\Models\OpportunityStage;
use App\Models\AboutUsOption;
use App\Models\County;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('opportunity.opportunities');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->getDropDownData();
        return view('opportunity.create.__create', compact('data'));
    }
    public function  getCustomerDetails($id)
    {
        $customer = Customer::query()
            ->select([
                'id',
                'customer_name',
                'address',
                'address_2',
                'city',
                'zip',
                'country_id',
                'phone',
                'fax',
                'mobile',
                'email',
                'price_list_label_id',
                'sales_person_id',
                'secondary_sales_person_id',
                'sales_tax_id'
            ])
            ->findOrFail($id);

        // Return a JSON response
        return response()->json($customer);
    }

    public function getDropDownData()
    {
        $companies = Company::query()->select('id', 'company_name')->get();
        $paymentTerms = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $users = User::query()->select('id', 'first_name')->get();
        $customerTypes = CustomerType::query()->select('id', 'customer_type_name')->get();
        $customers = Customer::query()->select('id', 'customer_name', 'customer_code', 'mobile', 'address')->get();
        $customerCount = Customer::query()->count();
        $associates = Associate::query()->select('id', 'associate_name')->get();
        $counties            = County::query()->pluck('county_name', 'id');
        $countries           = Country::query()->pluck('country_name', 'id');
        $priceListLabels     = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        $salesTaxs           = DB::table('tax_codes')->join('tax_code_components', 'tax_codes.id', '=', 'tax_code_components.tax_code_id')
            ->select('tax_codes.id', DB::raw("CONCAT(tax_codes.tax_code, ' - ', tax_codes.tax_code_label, ' - ', SUM(tax_code_components.rate), ' %') as name"))
            ->groupBy('tax_codes.id')
            ->get()->pluck('name', 'id');
        $endUseSegments = EndUseSegment::query()->pluck('end_use_segment', 'id');
        $projectTypes = ProjectType::query()->pluck('project_type_name', 'id');
        $opportunityStages = OpportunityStage::query()->pluck('opportunity_stage', 'id');
        $aboutUsOptions      = AboutUsOption::query()->pluck('how_did_you_hear_option', 'id');
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'endUseSegments', 'projectTypes', 'opportunityStages', 'aboutUsOptions');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Opportunity $opportunity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opportunity $opportunity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opportunity $opportunity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opportunity $opportunity)
    {
        //
    }
}
