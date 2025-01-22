<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Hold;
use App\Models\Quote;
use App\Models\Visit;
use App\Models\County;
use App\Models\Company;
use App\Models\Country;
use App\Models\TaxCode;
use App\Models\Customer;
use App\Models\FileType;
use App\Models\EventType;
use App\Models\Associate;
use App\Models\Opportunity;
use App\Models\ProjectType;
use App\Models\SampleOrder;
use Illuminate\Http\Request;
use App\Models\CustomerType;
use App\Models\EndUseSegment;
use App\Models\PriceListLabel;
use App\Models\AboutUsOption;
use App\Models\OpportunityStage;
use App\Models\AccountPaymentTerm;
use App\Models\OpportunityContact;
use App\Models\ProbabilityToClose;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\OpportunityRepository;
use App\Http\Requests\Opportunity\{CreateOpportunityRequest, UpdateOpportunityRequest};

class OpportunityController extends Controller
{
    private OpportunityRepository $opportunityRepository;

    public function __construct(OpportunityRepository $opportunityRepository)
    {
        $this->opportunityRepository = $opportunityRepository;
    }
    public function index()
    {
        return view('opportunity.opportunities');
    }

    public function create()
    {
        $data = $this->getDropDownData();
        $count = Opportunity::count();
        return view('opportunity.create.__create', compact('data', 'count'));
    }

    public function getDropDownData()
    {
        $companies = Company::query()->select('id', 'company_name')->get();
        $paymentTerms = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $users = User::query()->select(DB::raw("CONCAT(first_name, ' - ', last_name) as name"), 'id')->pluck('name', 'id');
        $customerTypes = CustomerType::query()->select('id', 'customer_type_name')->get();
        $customers = Customer::query()->select('id', 'customer_name', 'customer_code', 'mobile', 'address')->get();
        $customerCount = Customer::query()->count();
        $associates = Associate::query()->select('id', 'associate_name')->get();
        $counties            = County::query()->pluck('county_name', 'id');
        $countries           = Country::query()->pluck('country_name', 'id');
        $priceListLabels     = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        $salesTaxs           = TaxCode::query()->select(DB::raw("CONCAT(tax_code, ' - ', tax_code_label) as tax_name"), 'id')->pluck('tax_name', 'id');
        $endUseSegments = EndUseSegment::query()->pluck('end_use_segment', 'id');
        $projectTypes = ProjectType::query()->pluck('project_type_name', 'id');
        $opportunityStages = OpportunityStage::query()->pluck('opportunity_stage', 'id');
        $aboutUsOptions      = AboutUsOption::query()->pluck('how_did_you_hear_option', 'id');
        $probabilityCloses      = ProbabilityToClose::query()->pluck('probability_to_close', 'id');
        $eventTypes     = EventType::query()->pluck('event_type_name', 'id');
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'endUseSegments', 'projectTypes', 'opportunityStages', 'aboutUsOptions', 'probabilityCloses', 'eventTypes');
    }

    public function store(CreateOpportunityRequest $request)
    {
        try {
            $this->opportunityRepository->store($request->only('opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id'));
            return response()->json(['status' => 'success', 'msg' => 'opportunity saved successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error saving opportunity: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the opportunity option.']);
        }
    }

    public function show($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $customer = Customer::find($opportunity->billing_customer_id);
        $company = $opportunity ? Company::find($opportunity->location_id) : null;
        $user = User::find($opportunity->login_user_id);
        $primary_sales = $opportunity->primary_sales_person_id ? User::find($opportunity->primary_sales_person_id) : null;
        $secondary_sales = $opportunity->secondary_sales_person_id ? User::find($opportunity->secondary_sales_person_id) : null;
        $user = User::find($opportunity->login_user_id);
        $taxcode = $opportunity->sales_tax_id ? TaxCode::find($opportunity->sales_tax_id) : null;
        $price_list = PriceListLabel::find($opportunity->price_level_label_id);
        $payment_term = $customer ? AccountPaymentTerm::find($customer->payment_terms_id) : null;
        $date = $opportunity->opportunity_date ? \Carbon\Carbon::parse($opportunity->opportunity_date)->format('M d, Y') : null;
        $opportunity_date = $opportunity->updated_at ? \Carbon\Carbon::parse($opportunity->updated_at)->format('M d Y g:iA') : null;
        $how_did_hear = $opportunity->how_did_hear_about_us_id ? AboutUsOption::find($opportunity->how_did_hear_about_us_id) : null;
        $opportunity_contacts = OpportunityContact::where('opportunity_id', $id)
            ->with('contact')
            ->get();
        $contacts = $opportunity_contacts->map(function ($opportunity_contact) {
            return [
                'name' => optional($opportunity_contact->contact)->contact_name ?? 'Unknown Contact',
                'opportunity_contact_id' => $opportunity_contact->id,
            ];
        });

        $fileTypes = FileType::where('file_type_opportunity', 1)->select('id', 'file_Type')->get();
        $data = $this->getDropDownData();
        $quoteCount = Quote::where('opportunity_id', $opportunity->id)->count();
        $visitCount = Visit::where('opportunity_id', $opportunity->id)->count();
        $sampleOrderCount = SampleOrder::where('opportunity_id', $opportunity->id)->count();
        $holdCount = Hold::where('opportunity_id', $opportunity->id)->count();
        if (!empty($opportunity->total_value)) {
            $total = number_format($opportunity->total_value, 3);
        } else {
            $total = collect([
                Quote::where('opportunity_id', $opportunity->id)->sum('total'),
                Visit::where('opportunity_id', $opportunity->id)->sum('total'),
                SampleOrder::where('opportunity_id', $opportunity->id)->sum('total'),
                Hold::where('opportunity_id', $opportunity->id)->sum('total'),
            ])->sum();

            // Optionally assign this calculated total to $opportunity->total_value
            $total = number_format($total, 3);
        }

        return view('opportunity.show.__show', compact('opportunity', 'customer', 'company', 'date', 'opportunity_date', 'user', 'primary_sales', 'secondary_sales', 'taxcode', 'price_list', 'payment_term', 'how_did_hear', 'contacts', 'fileTypes', 'data', 'quoteCount', 'visitCount', 'sampleOrderCount', 'holdCount', 'total'));
    }

    public function edit($id)
    {
        $data = $this->getDropDownData();
        $opportunity = $this->opportunityRepository->findOrFail($id);
        $billCustomer = Customer::find($opportunity->billing_customer_id);
        $fabricator = Associate::find($opportunity->fabricator_id) ?? new Associate(['associate_name' => '']);
        $designer = Associate::find($opportunity->designer_id) ?? new Associate(['associate_name' => '']);
        $builder = Associate::find($opportunity->builder_id) ?? new Associate(['associate_name' => '']);
        if (!empty($opportunity->total_value)) {
            $opportunity->total_value = number_format($opportunity->total_value, 3);
        } else {
            $total = collect([
                Quote::where('opportunity_id', $opportunity->id)->sum('total'),
                Visit::where('opportunity_id', $opportunity->id)->sum('total'),
                SampleOrder::where('opportunity_id', $opportunity->id)->sum('total'),
                Hold::where('opportunity_id', $opportunity->id)->sum('total'),
            ])->sum();

            // Optionally assign this calculated total to $opportunity->total_value
            $opportunity->total_value = number_format($total, 3);
        }


        return view('opportunity.edit.__edit', compact(
            'opportunity',
            'billCustomer',
            'fabricator',
            'designer',
            'builder',
            'data',
            'total'
        ));
    }

    public function update(UpdateOpportunityRequest $request, Opportunity $opportunity)
    {
        try {
            $this->opportunityRepository->update($request->only('opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id'), $opportunity->id);
            return response()->json(['status' => 'success', 'msg' => 'Opportunity updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Opportunity: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Opportunity.']);
        }
    }

    public function updateInternalNotes(Request $request, $id)
    {
        try {
            $opportunity = Opportunity::findOrFail($id);
            $existingNotes = $opportunity->internal_notes ?? '';
            $newNotes = $request->input('internal_notes');
            $opportunity->internal_notes = $existingNotes . "\n" . $newNotes;
            $opportunity->save();
            return response()->json([
                'status' => 'success',
                'msg' => 'Internal notes updated successfully.',
                'data' => $opportunity->internal_notes
            ]);
        } catch (Exception $e) {
            Log::error('Error updating internal notes: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating internal notes.']);
        }
    }
    public function updateProbabilityClose(Request $request, $id)
    {
        try {
            $opportunity = Opportunity::findOrFail($id);
            $opportunity->probability_to_close_id = $request->input('probability_to_close_id');
            $opportunity->save();
            return response()->json(['status' => 'success', 'msg' => 'Probability close updated successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error updating probability close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating probability close.']);
        }
    }

    public function updateStages(Request $request, $id)
    {
        try {
            $opportunity = Opportunity::findOrFail($id);
            $opportunity->opportunity_stage_id = $request->input('opportunity_stage_id');
            $opportunity->save();
            return response()->json(['status' => 'success', 'msg' => 'Opportunity Stage updated successfully.']);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error updating Opportunity Stage: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Opportunity Stage.']);
        }
    }

    public function updateSurveyRate(Request $request, $id)
    {
        try {
            $opportunity = Opportunity::findOrFail($id);
            $opportunity->survey_rating_notes = $request->input('survey_rating_notes');
            $opportunity->save();
            return response()->json(['status' => 'success', 'msg' => 'Opportunity Survey Rating updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Opportunity Survey Rating: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Opportunity Survey Rating.']);
        }
    }

    public function getOpportunityDataTableList(Request $request)
    {
        return $this->opportunityRepository->dataTable($request);
    }
    public function getAllCustomerDataTableList(Request $request)
    {
        return $this->opportunityRepository->dataTableAllCustomer($request);
    }

    public function getAllAssociateDataTableList(Request $request)
    {
        return $this->opportunityRepository->dataTableAllAssociate($request);
    }

    public function getAllShipToDataTableList(Request $request, $id)
    {
        return $this->opportunityRepository->dataTableAllShipTo($request, $id);
    }

    public function getAllSubtransactionDataTableList(Request $request, $id)
    {
        return $this->opportunityRepository->dataTableAllSubtransaction($request, $id);
    }
}
