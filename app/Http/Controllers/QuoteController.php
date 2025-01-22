<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Hold;
use App\Models\Visit;
use App\Models\Quote;
use App\Models\County;
use App\Models\Service;
use App\Models\TaxCode;
use App\Models\Company;
use App\Models\Account;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\FileType;
use App\Models\EventType;
use App\Models\Associate;
use App\Models\ServiceType;
use App\Models\QuoteFooter;
use App\Models\ProjectType;
use App\Models\QuoteHeader;
use App\Models\Opportunity;
use App\Models\ProductType;
use App\Models\SampleOrder;
use App\Models\QuoteContact;
use App\Models\QuoteProduct;
use App\Models\QuoteService;
use App\Models\TaxComponent;
use Illuminate\Http\Request;
use App\Models\CustomerType;
use App\Models\ProductGroup;
use App\Models\EndUseSegment;
use App\Models\AboutUsOption;
use App\Models\PaymentMethod;
use App\Models\PriceListLabel;
use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\QuotePrintedNote;
use App\Models\OpportunityStage;
use App\Models\ProductPriceRange;
use App\Models\ProbabilityToClose;
use App\Models\ProductSubCategory;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\QuoteRepository;
use App\Repositories\OpportunityRepository;
use App\Http\Requests\Quote\{CreateQuoteRequest, UpdateQuoteRequest};
use App\Http\Requests\Opportunity\CreateOpportunityRequest;

class QuoteController extends Controller
{
    private QuoteRepository $quoteRepository;
    private OpportunityRepository $opportunityRepository;
    public function __construct(QuoteRepository $quoteRepository, OpportunityRepository $opportunityRepository)
    {
        $this->quoteRepository = $quoteRepository;
        $this->opportunityRepository = $opportunityRepository;
    }

    public function indexQuote($id)
    {
        $data = $this->getDropDownData();
        $opportunity = Opportunity::findOrFail($id);
        $customer = $opportunity?->customer;
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $taxcode = $opportunity?->sales_tax;
        $price_list = $opportunity?->price_list;
        $payment_term = $customer?->payment_term;
        $endUseSegment = $opportunity?->end_use_segment;
        $howDidHear = $opportunity?->how_did_you_hear;
        $projectType = $opportunity?->project_type;
        $company = $opportunity?->location;
        $primarySale = $opportunity?->primary_user;
        $secondarySale = $opportunity?->secondary_user;
        $fabricator = $opportunity?->fabricator;
        return view('quote.create.__create_quotes', compact('data', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator'));
    }

    public function store(CreateQuoteRequest $request)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $quote = $this->quoteRepository->store($request->only('opportunity_id', 'quote_label', 'quote_date', 'quote_time', 'expiry_date', 'customer_po', 'price_level_id', 'end_use_segment_id', 'project_type_id', 'eta_date', 'payment_terms_id', 'sales_tax_id', 'secondary_sales_person_id', 'quote_header_id', 'quote_footer_id', 'quote_printed_notes_id', 'quote_printed_note', 'quote_internal_note', 'probability_close_id', 'survey_rating', 'total', 'status_update_date', 'status_update_user_id', 'notes', 'status'));
            return response()->json(['status' => 'success', 'msg' => 'Quote saved successfully.', 'quote_id' => $quote->id]);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error saving Quote: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Quote.']);
        }
    }


    public function show($id)
    {
        $data = $this->getDropDownData();
        $quote = Quote::findOrFail($id);
        $opportunity = Opportunity::findOrFail($quote->opportunity_id);
        $sampleOrders = Quote::where('opportunity_id', $quote->opportunity_id)
            ->orderBy('created_at', 'asc')
            ->get();
        $position = $sampleOrders->search(function ($item) use ($id) {
            return $item->id == $id;
        }) + 1;
        $quoteCount = Quote::where('opportunity_id', $quote->opportunity_id)->count();
        $visitCount = Visit::where('opportunity_id', $quote->opportunity_id)->count();
        $sampleOrderCount = SampleOrder::where('opportunity_id', $quote->opportunity_id)->count();
        $holdCount = Hold::where('opportunity_id', $quote->opportunity_id)->count();
        $quoteDate = $quote->created_at ? \Carbon\Carbon::parse($quote->created_at)->format('M d Y g:iA') : null;
        $opportunity_date = $opportunity->created_at ? \Carbon\Carbon::parse($opportunity->created_at)->format('M d Y g:iA') : null;
        $paymentTerm = $quote?->payment_term;
        $priceList = $quote?->price_list;
        $taxCode = $quote?->sales_tax;
        $endUseSegment = $opportunity?->end_use_segment;
        $projectType = $opportunity?->project_type;
        $company = $opportunity?->location;
        $customer = $opportunity?->customer;
        $primarySale = $opportunity?->primary_user;
        $secondarySale = $opportunity?->secondary_user;
        $loginPerson = optional(User::find($opportunity->login_user_id));
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        $fabricator = $opportunity?->fabricator;
        $designer = $opportunity?->designer;
        $builder = $opportunity?->builder;
        $howDidHear = $opportunity?->how_did_you_hear;
        $fileTypes = FileType::where('view_in', 'Transaction')->where('file_type_saleorder', '1')->select('id', 'file_Type')->get();
        $quoteContacts = QuoteContact::where('quote_id', $id)
            ->with('contact')
            ->get();
        $contacts = $quoteContacts->map(function ($quoteContact) {
            return [
                'name' => optional($quoteContact->contact)->contact_name ?? 'Unknown Contact',
                'quote_contact_id' => $quoteContact->id,
            ];
        });
        return view('quote.show.__show', compact('data', 'quote', 'opportunity', 'position', 'quoteDate', 'opportunity_date', 'paymentTerm', 'company', 'priceList', 'customer', 'primarySale', 'secondarySale', 'taxCode', 'endUseSegment', 'projectType', 'taxAmount', 'loginPerson', 'fabricator', 'designer', 'builder', 'howDidHear', 'quoteCount', 'visitCount', 'sampleOrderCount', 'holdCount', 'fileTypes', 'contacts'));
    }

    public function updateProbabilityClose(Request $request, $id)
    {
        try {
            $sampleOrder = Quote::findOrFail($id);
            $sampleOrder->probability_close_id = $request->input('probability_close_id');
            $sampleOrder->save();
            return response()->json(['status' => 'success', 'msg' => 'Quote Probability close updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote probability close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Quote probability close.']);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $sampleOrder = Quote::findOrFail($id);
            $sampleOrder->status = $request->input('status');
            $sampleOrder->save();
            return response()->json(['status' => 'success', 'msg' => 'Quote Status updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Quote Status.']);
        }
    }

    public function updateInternalNotes(Request $request, $id)
    {
        try {
            $quote = Quote::findOrFail($id);
            $existingNotes = $quote->quote_internal_note ?? '';
            $newNotes = $request->input('quote_internal_note');
            $quote->quote_internal_note = $existingNotes . "\n" . $newNotes;
            $quote->save();
            return response()->json([
                'status' => 'success',
                'msg' => 'Quote Internal notes updated successfully.',
                'data' => $quote->quote_internal_note
            ]);
        } catch (Exception $e) {
            Log::error('Error updating Quote Internal notes: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Quote Internal notes.']);
        }
    }

    public function updateSurveyRate(Request $request, $id)
    {
        try {
            $quote = Quote::findOrFail($id);
            $quote->survey_rating = $request->input('survey_rating');
            $quote->save();
            return response()->json(['status' => 'success', 'msg' => 'Quote Survey Rating updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Survey Rating: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Quote Survey Rating.']);
        }
    }

    public function updateQuoteStatus(Request $request, $id)
    {
        try {
            $quote = Quote::findOrFail($id);
            $quote->status_update_date = $request->input('status_update_date');
            $quote->status_update_user_id = $request->input('status_update_user_id');
            $quote->status = $request->input('status');
            if ($quote->status == 'close') {
                $quote->notes = $request->input('notes');
            } else {
                $quote->notes = '';
            }
            $quote->save();
            return response()->json(['status' => 'success', 'msg' => 'Quote Status updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Quote Status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Quote Status.']);
        }
    }

    public function indexOpportunityQuote()
    {
        $data = $this->getDropDownData();
        $count = Opportunity::count();
        return view('quote.create.__create_oppotunity_quotes', compact('data', 'count'));
    }

    public function saveOpportunityQuote(Request $request, CreateOpportunityRequest $requestOpportunity)
    {
        try {
            $request->validate([
                'payment_terms_id' => 'required|exists:account_payment_terms,id',
                'eta_date' => 'nullable|date',
                'quote_printed_notes_id' => 'nullable|integer',
                'quote_header_id' => 'nullable|integer',
                'quote_footer_id' => 'nullable|integer',
            ]);

            // Gather Opportunity data
            $opportunityData = $requestOpportunity->only('opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id');

            $quoteData = [
                'quote_date' => now()->format('Y-m-d'),
                'quote_time' => now()->format('h:i:s A'),
                'payment_terms_id' => $request->input('payment_terms_id'),
                'eta_date' => $request->input('eta_date') ?? null,
                'quote_printed_notes_id' => $request->input('quote_printed_notes_id') ?? null,
                'quote_header_id' => $request->input('quote_header_id') ?? null,
                'quote_footer_id' => $request->input('quote_footer_id') ?? null,
            ];
            $quote = null; // Define the variable outside the transaction

            // Save Opportunity and Quote transactionally
            DB::transaction(function () use ($opportunityData, &$quoteData, &$quote) {
                $opportunity = $this->opportunityRepository->store($opportunityData);
                $quoteData['opportunity_id'] = $opportunity->id;
                $quote = $this->quoteRepository->store($quoteData);
            });

            // Return the quote ID after saving
            return response()->json([
                'status' => 'success',
                'msg' => 'Opportunity and Quote saved successfully.',
                'quote_id' => $quote->id,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error('Error saving Opportunity or Quote: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the Opportunity or Quote.',
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = $this->getDropDownData();
        $quote = Quote::findOrFail($id);
        $opportunity = $quote->opportunities;
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $company = $opportunity?->location;
        $price_list = $opportunity?->price_list;
        $customer = $opportunity?->customer;
        $primary_sales = $opportunity?->primary_user;
        $secondary_sales = $opportunity?->secondary_user;
        $taxcode = $opportunity?->sales_tax;
        $payment_term = $customer?->payment_term;
        $endUseSegment = $opportunity?->end_use_segment;
        $howDidHear = $opportunity?->how_did_you_hear;
        $projectType = $opportunity?->project_type;
        $primarySale = $opportunity?->primary_user;
        $secondarySale = $opportunity?->secondary_user;
        $fabricator = $opportunity?->fabricator;
        return view('quote.edit.__edit_quotes', compact('data', 'quote', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator'));
    }

    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $this->quoteRepository->update($request->only('opportunity_id', 'quote_label', 'quote_date', 'quote_time', 'expiry_date', 'customer_po', 'price_level_id', 'end_use_segment_id', 'project_type_id', 'eta_date', 'payment_terms_id', 'sales_tax_id', 'secondary_sales_person_id', 'quote_header_id', 'quote_footer_id', 'quote_printed_notes_id', 'quote_printed_note', 'quote_internal_note', 'probability_close_id', 'survey_rating', 'total', 'status_update_date', 'status_update_user_id', 'notes', 'status'), $quote->id);
            return response()->json(['status' => 'success', 'msg' => 'Quote Updated successfully.', 'quote_id' => $quote->id]);
        } catch (Exception $e) {
            Log::error('Error updating Quote: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Quote.']);
        }
    }

    public function destroy($id)
    {
        try {
            $quote = $this->quoteRepository->findOrFail($id);
            $this->quoteRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Quote deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Quote: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Quote.'], 500);
        }
    }

    public function indexConvertVisitAndSample($id, Request $request)
    {
        $type = $request->query('type');
        $data = $this->getDropDownData();
        $quote = Quote::findOrFail($id);
        $opportunity = $quote->opportunities;
        $customer = $opportunity?->customer;
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $taxcode = $opportunity?->sales_tax;
        $taxAmount = $taxcode ? TaxComponent::where('tax_code_id', $taxcode->id)->first() : null;
        $price_list = $opportunity?->price_list;
        $payment_term = $customer?->payment_term;
        $endUseSegment = $opportunity?->end_use_segment;
        $howDidHear = $opportunity?->how_did_you_hear;
        $projectType = $opportunity?->project_type;
        $company = $opportunity?->location;
        $primarySale = $opportunity?->primary_user;
        $secondarySale = $opportunity?->secondary_user;
        $fabricator = $opportunity?->fabricator;
        $designer = $opportunity?->designer;
        $builder = $opportunity?->builder;
        $quoteProducts = QuoteProduct::with(['product.unit_measure'])->where('quote_id', $id)->get();
        $quoteServices = QuoteService::with(['service.unit_measure'])->where('quote_id', $id)->get();
        if ($type == 'visit') {
            return view('opportunity.opportunity_convert.quote_converts.visit', compact('data', 'quote', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'taxAmount', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator', 'designer', 'builder', 'quoteProducts', 'quoteServices'));
        } elseif ($type == 'sample') {
            return view('opportunity.opportunity_convert.quote_converts.sample_order', compact('data', 'quote', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'taxAmount', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator', 'designer', 'builder', 'quoteProducts', 'quoteServices'));
        }
    }

    public function getQuoteDataTableList(Request $request)
    {
        return $this->quoteRepository->dataTableQuote($request);
    }

    public function getAllQuoteDataTableList(Request $request, $id)
    {
        return $this->quoteRepository->dataTableQuoteAll($request, $id);
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
        $productTypes = ProductType::query()->pluck('product_type', 'id');
        $productCategories = ProductCategory::query()->pluck('product_category_name', 'id');
        $suppliers = Supplier::query()->pluck('supplier_name', 'id');
        $services = Service::query()->pluck('service_name', 'id');
        $quoteFooter = QuoteFooter::query()->pluck('quote_footer_name', 'id');
        $quoteHeader = QuoteHeader::query()->pluck('quote_header_name', 'id');
        $quotePrintedNote = QuotePrintedNote::query()->pluck('quote_printed_notes_name', 'id');
        $documentFooters = DB::table('print_doc_disclaimers')
            ->join('select_type_categories', 'print_doc_disclaimers.select_type_category_id', '=', 'select_type_categories.id')
            ->join('select_type_sub_categories', function ($join) {
                $join->on('print_doc_disclaimers.select_type_sub_category_id', '=', 'select_type_sub_categories.id')
                    ->on('select_type_categories.id', '=', 'select_type_sub_categories.select_type_category_id');
            })
            ->where('select_type_categories.select_type_category_name', 'Sample Order')
            ->where('select_type_sub_categories.select_type_sub_category_name', 'Sample Order Footer')
            ->select(
                'print_doc_disclaimers.id',
                DB::raw("CONCAT(print_doc_disclaimers.title, ' ', print_doc_disclaimers.policy) as policy_name")
            )
            ->pluck('policy_name', 'id');
        $productSubCategory = ProductSubCategory::query()->pluck('product_sub_category_name', 'id');
        $productPriceRange = ProductPriceRange::query()->pluck('product_price_range', 'id');
        $productGroup = ProductGroup::query()->pluck('product_group_name', 'id');
        $serviceType = ServiceType::query()->pluck('service_type', 'id');
        $serviceCategory = ServiceCategory::query()->pluck('service_category', 'id');
        $supplier = Supplier::query()->pluck('supplier_name', 'id');
        $account = Account::query()->pluck('account_name', 'id');
        $paymentMethods = PaymentMethod::query()->pluck('payment_method_name', 'id');
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'endUseSegments', 'projectTypes', 'opportunityStages', 'aboutUsOptions', 'probabilityCloses', 'eventTypes', 'productTypes', 'productCategories', 'suppliers', 'services', 'quoteFooter', 'quoteHeader', 'quotePrintedNote', 'documentFooters', 'productSubCategory', 'productPriceRange', 'productGroup', 'serviceType', 'serviceCategory', 'supplier', 'account', 'paymentMethods');
    }
}
