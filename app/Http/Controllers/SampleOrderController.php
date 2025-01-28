<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Hold;
use App\Models\Quote;
use App\Models\Visit;
use App\Models\County;
use App\Models\Service;
use App\Models\TaxCode;
use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\FileType;
use App\Models\EventType;
use App\Models\Associate;
use App\Models\SampleOrder;
use App\Models\Opportunity;
use App\Models\ProjectType;
use App\Models\ProductType;
use App\Models\QuoteFooter;
use App\Models\QuoteHeader;
use App\Models\TaxComponent;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Models\EndUseSegment;
use App\Models\AboutUsOption;
use App\Models\PriceListLabel;
use App\Models\ProductCategory;
use App\Models\OpportunityStage;
use App\Models\QuotePrintedNote;
use App\Models\ProbabilityToClose;
use App\Models\SampleOrderContact;
use App\Models\SampleOrderProduct;
use App\Models\SampleOrderService;
use Illuminate\Support\Facades\DB;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\QuoteRepository;
use App\Repositories\SampleOrderRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\VisitRepository;
use App\Http\Requests\Opportunity\CreateOpportunityRequest;
use App\Http\Requests\SampleOrder\Opportunity\UpdateOpportunitySampleOrderRequest;
use App\Http\Requests\SampleOrder\{CreateSampleOrderRequest, UpdateSampleOrderRequest};
use App\Http\Requests\SampleOrder\SampleOrderProduct\{CreateSampleOrderProductRequest, UpdateSampleOrderProductRequest};
use App\Http\Requests\SampleOrder\SampleOrderService\{CreateSampleOrderServiceRequest, UpdateSampleOrderServiceRequest};

class SampleOrderController extends Controller
{
    private SampleOrderRepository $sampleOrderRepository;
    private OpportunityRepository $opportunityRepository;
    private VisitRepository $visitRepository;
    private QuoteRepository $quoteRepository;
    public function __construct(SampleOrderRepository $sampleOrderRepository, OpportunityRepository $opportunityRepository, VisitRepository $visitRepository, QuoteRepository $quoteRepository)
    {
        $this->opportunityRepository = $opportunityRepository;
        $this->sampleOrderRepository = $sampleOrderRepository;
        $this->visitRepository = $visitRepository;
        $this->quoteRepository = $quoteRepository;
    }

    public function indexSampleOrder($id)
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
        return view('sample_order.create.__create_sample_orders', compact('data', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator'));
    }

    public function store(CreateSampleOrderRequest $request)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $sampleOrder = $this->sampleOrderRepository->store($request->only('opportunity_id', 'sample_order_label', 'sample_order_date', 'sample_order_time', 'sales_person_id', 'delivery_type', 'delivery_attn', 'delivery_tracking', 'delivery_address', 'delivery_suite', 'delivery_city', 'delivery_state', 'delivery_zip', 'delivery_country_id', 'delivery_county_id', 'document_footer_id', 'sample_order_printed_notes', 'probability_close_id', 'status', 'total'));
            return response()->json(['status' => 'success', 'msg' => 'Sample Order saved successfully.', 'sample_order_id' => $sampleOrder->id]);
        } catch (Exception $e) {
            Log::error('Error saving Sample Order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Sample Order.']);
        }
    }
    public function indexProductSampleOrder($id)
    {
        $data = $this->getDropDownData();
        $sampleOrder = SampleOrder::findOrFail($id);
        $opportunity = $sampleOrder->opportunities;
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $company = $opportunity?->location;
        $price_list = $opportunity?->price_list;
        $customer = $opportunity?->customer;
        $primary_sales = $opportunity?->primary_user;
        $secondary_sales = $opportunity?->secondary_user;
        $taxCode = $opportunity?->sales_tax;
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        return view('sample_order.create.__create_sample_order_products', compact(
            'data',
            'sampleOrder',
            'opportunity',
            'opportunity_date',
            'company',
            'price_list',
            'customer',
            'primary_sales',
            'secondary_sales',
            'taxCode',
            'taxAmount'
        ));
    }

    public function saveSampleOrderProduct(Request $request, CreateSampleOrderProductRequest $createSampleOrderProductRequest, CreateSampleOrderServiceRequest $createSampleOrderServiceRequest)
    {
        DB::beginTransaction();
        try {
            $validated = $createSampleOrderProductRequest->validated();
            $validatedService = $createSampleOrderServiceRequest->validated();

            $sampleOrder = SampleOrder::findOrFail($request->input('sample_order_id'));
            $sampleOrder->update([
                'sample_order_printed_notes' => $request->input('sample_order_printed_notes'),
                'total' => $request->input('total'),
            ]);
            $opportunity = Opportunity::findOrFail($request->input('opportunity_id'));
            $opportunity->update([
                'secondary_sales_person_id' => $request->input('secondary_sales_person_id'),
                'ship_to_job_name' => $request->input('ship_to_job_name'),
                'ship_to_address' => $request->input('ship_to_address'),
                'ship_to_suite' => $request->input('ship_to_suite'),
                'ship_to_city' => $request->input('ship_to_city'),
                'ship_to_state' => $request->input('ship_to_state'),
                'ship_to_zip' => $request->input('ship_to_zip'),
                'internal_notes' => $request->input('internal_notes'),
            ]);
            SampleOrderProduct::where('sample_order_id', $sampleOrder->id)->delete();
            $productsData = [];
            if (!empty($validated['product_id'])) {
                foreach ($validated['product_id'] as $key => $product) {
                    if ($product) {
                        $productsData[] = [
                            'product_id' => $product ?? null,
                            'is_sold_as' => $validated['is_sold_as'][$key] ?? false,
                            'product_description' => $validated['product_description'][$key] ?? null,
                            'product_quantity' => $validated['product_quantity'][$key] ?? null,
                            'sample_quantity' => $validated['sample_quantity'][$key] ?? null,
                            'product_unit_price' => $validated['product_unit_price'][$key] ?? null,
                            'product_amount' => $validated['product_amount'][$key] ?? null,
                        ];
                    }
                }
            }
            if (!empty($productsData)) {
                $sampleOrder->sample_order_products()->createMany($productsData);
            }
            SampleOrderService::where('sample_order_id', $sampleOrder->id)->delete();
            $servicesData = [];
            foreach ($validatedService['service_id'] as $key => $service) {
                if ($service) {
                    $servicesData[] = [
                        'service_id' => $service ?? null,
                        'service_description' => $validatedService['service_description'][$key] ?? null,
                        'service_quantity' => $validatedService['service_quantity'][$key] ?? null,
                        'service_unit_price' => $validatedService['service_unit_price'][$key] ?? null,
                        'service_amount' => $validatedService['service_amount'][$key] ?? null,
                        'is_tax' => $validatedService['is_tax'][$key] ?? false,
                    ];
                }
            }
            if (!empty($servicesData)) {
                $sampleOrder->sample_order_services()->createMany($servicesData);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'msg' => 'Sample Order data saved successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error saving Sample Order data', ['error' => $e->getMessage()]);
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $data = $this->getDropDownData();
        $sampleOrder = SampleOrder::findOrFail($id);
        $opportunity = Opportunity::findOrFail($sampleOrder->opportunity_id);
        $sampleOrders = SampleOrder::where('opportunity_id', $sampleOrder->opportunity_id)
            ->orderBy('created_at', 'asc')
            ->get();
        $position = $sampleOrders->search(function ($item) use ($id) {
            return $item->id == $id;
        }) + 1;
        $sampleOrderCount = SampleOrder::where('opportunity_id', $sampleOrder->opportunity_id)->count();
        $visitCount = Visit::where('opportunity_id', $sampleOrder->opportunity_id)->count();
        $holdCount = Hold::where('opportunity_id', $sampleOrder->opportunity_id)->count();
        $quoteCount = Quote::where('opportunity_id', $sampleOrder->opportunity_id)->count();
        $sampleOrderDate = $sampleOrder->created_at ? \Carbon\Carbon::parse($sampleOrder->created_at)->format('M d Y g:iA') : null;
        $opportunity_date = $opportunity->created_at ? \Carbon\Carbon::parse($opportunity->created_at)->format('M d Y g:iA') : null;

        $company = $opportunity?->location;
        $priceList = $opportunity?->price_list;
        $customer = $opportunity?->customer;
        $primarySale = $opportunity?->primary_user;
        $secondarySale = $opportunity?->secondary_user;
        $loginPerson = optional(User::find($opportunity->login_user_id));
        $taxCode = $opportunity?->sales_tax;
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        $fabricator = $opportunity?->fabricator;
        $designer = $opportunity?->designer;
        $builder = $opportunity?->builder;
        $howDidHear = $opportunity?->how_did_you_hear;
        $fileTypes = FileType::where('view_in', 'Transaction')->where('file_type_saleorder', '1')->select('id', 'file_Type')->get();
        $sampleOrderContacts = SampleOrderContact::where('sample_order_id', $id)
            ->with('contact')
            ->get();
        $contacts = $sampleOrderContacts->map(function ($sampleOrderContacts) {
            return [
                'name' => optional($sampleOrderContacts->contact)->contact_name ?? 'Unknown Contact',
                'sample_order_contact_id' => $sampleOrderContacts->id,
            ];
        });
        $statuses = SampleOrder::$statuses;
        return view('sample_order.show.__show', compact(
            'data',
            'sampleOrder',
            'opportunity',
            'position',
            'sampleOrderDate',
            'opportunity_date',
            'company',
            'priceList',
            'customer',
            'primarySale',
            'secondarySale',
            'taxCode',
            'taxAmount',
            'loginPerson',
            'fabricator',
            'designer',
            'builder',
            'howDidHear',
            'sampleOrderCount',
            'visitCount',
            'holdCount',
            'quoteCount',
            'fileTypes',
            'contacts',
            'statuses'
        ));
    }

    public function updateProbabilityClose(Request $request, $id)
    {
        try {
            $sampleOrder = SampleOrder::findOrFail($id);
            $sampleOrder->probability_close_id = $request->input('probability_close_id');
            $sampleOrder->save();
            return response()->json(['status' => 'success', 'msg' => 'Sample Order Probability close updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Sample Order probability close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Sample Order probability close.']);
        }
    }
    public function updateStatus(Request $request, $id)
    {
        try {
            $sampleOrder = SampleOrder::findOrFail($id);
            $sampleOrder->status = $request->input('status');
            $sampleOrder->save();
            return response()->json(['status' => 'success', 'msg' => 'Sample Order Status updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Sample Order Status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Sample Order Status.']);
        }
    }

    public function getSampleOrderProductDataTableList(Request $request, $id)
    {
        return $this->sampleOrderRepository->dataTable($request, $id);
    }

    public function editSampleOrderProduct($id)
    {
        $data = $this->getDropDownData();
        $sampleOrder = SampleOrder::findOrFail($id);
        $sampleOrderProducts = SampleOrderProduct::join('products', 'sample_order_products.product_id', '=', 'products.id')
            ->where('sample_order_products.sample_order_id', $id)
            ->select('sample_order_products.*', 'products.product_name')
            ->get();
        $sampleOrderServices = SampleOrderService::join('services', 'sample_order_services.service_id', '=', 'services.id')
            ->where('sample_order_services.sample_order_id', $id)
            ->select('sample_order_services.*', 'services.service_name')
            ->get();
        $opportunity = Opportunity::findOrFail($sampleOrder->opportunity_id);
        $opportunity_date = $opportunity->created_at ? \Carbon\Carbon::parse($opportunity->created_at)->format('M d Y g:iA') : null;
        $company = $opportunity?->location;
        $price_list = $opportunity?->price_list;
        $customer = $opportunity?->customer;
        $primary_sales = $opportunity?->primary_user;
        $secondary_sales = $opportunity?->secondary_user;
        $taxCode = $opportunity?->sales_tax;
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        return view('sample_order.edit.__edit_sample_order_products', compact(
            'data',
            'sampleOrder',
            'sampleOrderProducts',
            'sampleOrderServices',
            'opportunity',
            'opportunity_date',
            'company',
            'price_list',
            'customer',
            'primary_sales',
            'secondary_sales',
            'taxCode',
            'taxAmount'
        ));
    }

    public function deleteSampleOrderProduct($id)
    {
        try {
            $sampleOrderProduct = SampleOrderProduct::findOrFail($id);
            if ($sampleOrderProduct) {
                $sampleOrderProduct->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Sample Order Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Sample Order Product not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Sample Order Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Sample Order Product.']);
        }
    }

    public function updateSampleOrderProduct(Request $request, UpdateSampleOrderProductRequest $updateSampleOrderProductRequest, UpdateSampleOrderServiceRequest $updateSampleOrderServiceRequest, $id)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('sample_order_id');
            $sampleOrder = SampleOrder::findOrFail($id);
            // Update visit data
            $sampleOrder->update([
                'sample_order_printed_notes' => $request->input('sample_order_printed_notes'),
                'total' => $request->input('total'),
            ]);
            // Update opportunity
            $opportunity = Opportunity::findOrFail($request->input('opportunity_id'));
            $opportunity->update([
                'secondary_sales_person_id' => $request->input('secondary_sales_person_id'),
                'ship_to_job_name' => $request->input('ship_to_job_name'),
                'ship_to_address' => $request->input('ship_to_address'),
                'ship_to_suite' => $request->input('ship_to_suite'),
                'ship_to_city' => $request->input('ship_to_city'),
                'ship_to_state' => $request->input('ship_to_state'),
                'ship_to_zip' => $request->input('ship_to_zip'),
                'internal_notes' => $request->input('internal_notes'),
            ]);
            // Update products
            $validated = $updateSampleOrderProductRequest->validated();
            SampleOrderProduct::where('sample_order_id', $sampleOrder->id)->delete(); // Delete existing products
            if (!empty($validated['product_id'])) {
                foreach ($validated['product_id'] as $key => $product) {
                    if ($product) {
                        SampleOrderProduct::create([
                            'sample_order_id' => $sampleOrder->id,
                            'product_id' => $product,
                            'is_sold_as' => $validated['is_sold_as'][$key] ?? false,
                            'product_description' => $validated['product_description'][$key] ?? null,
                            'product_quantity' => $validated['product_quantity'][$key] ?? null,
                            'sample_quantity' => $validated['sample_quantity'][$key] ?? null,
                            'product_unit_price' => $validated['product_unit_price'][$key] ?? null,
                            'product_amount' => $validated['product_amount'][$key] ?? null,
                        ]);
                    }
                }
            }

            // Update services
            $validatedService = $updateSampleOrderServiceRequest->validated();
            SampleOrderService::where('sample_order_id', $sampleOrder->id)->delete(); // Delete existing services
            if (!empty($validatedService['service_id'])) {
                foreach ($validatedService['service_id'] as $key => $service) {
                    if ($service) {
                        SampleOrderService::create([
                            'sample_order_id' => $sampleOrder->id,
                            'service_id' => $service,
                            'service_description' => $validatedService['service_description'][$key] ?? null,
                            'service_quantity' => $validatedService['service_quantity'][$key] ?? null,
                            'service_unit_price' => $validatedService['service_unit_price'][$key] ?? null,
                            'service_amount' => $validatedService['service_amount'][$key] ?? null,
                            'is_tax' => $validatedService['is_tax'][$key] ?? false,
                        ]);
                    }
                }
            }

            DB::commit();  // Commit the transaction
            return response()->json([
                'status' => 'success',
                'msg' => 'Sample Order Updated saved successfully.',
            ]);
        } catch (Exception $e) {
            DB::rollback();  // Rollback transaction on failure

            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function indexOpportunitySampleOrder()
    {
        $data = $this->getDropDownData();
        $count = Opportunity::count();
        return view('sample_order.create.__create_oppotunity_sample_orders', compact('data', 'count'));
    }

    public function saveOpportunitySampleOrder(Request $request, CreateOpportunityRequest $requestOpportunity)
    {
        try {
            $opportunityData = $requestOpportunity->only('opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id');
            $opportunity = $this->opportunityRepository->store($opportunityData);
            $sampleOrderData = [
                'sample_order_date' => now()->format('Y-m-d'),
                'sample_order_time' => now()->format('h:i:s A'),
                'opportunity_id' => $opportunity->id,
                'delivery_type' => $request->input('delivery_type'),
                'delivery_attn' => $request->input('delivery_attn'),
                'delivery_tracking' => $request->input('delivery_tracking'),
                'delivery_address' => $request->input('delivery_address'),
                'delivery_suite' => $request->input('delivery_suite'),
                'delivery_city' => $request->input('delivery_city'),
                'delivery_state' => $request->input('delivery_state'),
                'delivery_zip' => $request->input('delivery_zip'),
                'delivery_county_id' => $request->input('delivery_county_id'),
            ];
            $sampleOrder = $this->sampleOrderRepository->store($sampleOrderData);
            return response()->json([
                'status' => 'success',
                'msg' => 'Opportunity and Sample Order saved successfully.',
                'sample_order_id' => $sampleOrder->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving opportunity or Sample Order: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the opportunity or Sample Order. Please try again.',
            ], 500);
        }
    }

    public function editOpportunitySampleOrder($id)
    {
        $data = $this->getDropDownData();
        $sampleOrder = SampleOrder::findOrFail($id);
        $opportunity = $sampleOrder->opportunities;
        $billCustomer = $opportunity?->customer;
        $fabricator = $opportunity?->fabricator;
        $designer = $opportunity?->designer;
        $builder = $opportunity?->builder;
        return view('sample_order.edit.__edit_oppotunity_sample_orders', compact('data', 'sampleOrder', 'opportunity', 'billCustomer', 'fabricator', 'designer', 'builder'));
    }

    public function updateOpportunitySampleOrder(Request $request, $id, UpdateOpportunitySampleOrderRequest $updateOpportunitySampleOrderRequest)
    {
        try {
            $sampleOrderData = [
                'sample_order_date' => now()->toDateString(),
                'sample_order_time' => now()->toTimeString(),
                'sample_order_label' => $request->input('sample_order_label'),
                'opportunity_id' => $request->input('opportunity_id'),
                'delivery_type' => $request->input('delivery_type'),
                'delivery_attn' => $request->input('delivery_attn'),
                'delivery_tracking' => $request->input('delivery_tracking'),
                'delivery_address' => $request->input('delivery_address'),
                'delivery_suite' => $request->input('delivery_suite'),
                'delivery_city' => $request->input('delivery_city'),
                'delivery_state' => $request->input('delivery_state'),
                'delivery_zip' => $request->input('delivery_zip'),
                'delivery_county_id' => $request->input('delivery_county_id'),
                'sample_order_printed_notes' => $request->input('sample_order_printed_notes'),
                'sample_order_special_instructions' => $request->input('sample_order_special_instructions'),
            ];
            $sampleOrder_id = $request->input('sample_order_id');
            $this->sampleOrderRepository->update($sampleOrderData, $sampleOrder_id);
            $opportunityData = $updateOpportunitySampleOrderRequest->only(['opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id']);
            $this->opportunityRepository->update($opportunityData, $id);
            return response()->json([
                'status' => 'success',
                'msg' => 'Opportunity and Sample Order updated successfully.',
                'sample_order_id' => $sampleOrder_id,
            ]);
        } catch (Exception $e) {
            Log::error('Error updating opportunity or visit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while updating the opportunity or visit. Please try again.',
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = $this->getDropDownData();
        $sampleOrder = SampleOrder::findOrFail($id);
        $opportunity = $sampleOrder->opportunities;
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
        return view('sample_order.edit.__edit_sample_orders', compact('data', 'sampleOrder', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator'));
    }

    public function update(UpdateSampleOrderRequest $request, SampleOrder $sampleOrder)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $this->sampleOrderRepository->update($request->only('opportunity_id', 'sample_order_label', 'sample_order_date', 'sample_order_time', 'sales_person_id', 'delivery_type', 'delivery_attn', 'delivery_tracking', 'delivery_address', 'delivery_suite', 'delivery_city', 'delivery_state', 'delivery_zip', 'delivery_country_id', 'delivery_county_id', 'document_footer_id', 'sample_order_printed_notes', 'probability_close_id', 'status', 'total'), $sampleOrder->id);
            return response()->json(['status' => 'success', 'msg' => 'Sample Order Updated successfully.', 'sample_order_id' => $sampleOrder->id]);
        } catch (Exception $e) {
            Log::error('Error updating Sample Order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Sample Order.']);
        }
    }

    public function destroy($id)
    {
        try {
            $sampleOrder = $this->sampleOrderRepository->findOrFail($id);
            $this->sampleOrderRepository->delete($id);
            SampleOrderProduct::where('sample_order_id', $id)->delete();
            SampleOrderService::where('sample_order_id', $id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Sample Order deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Sample Order: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Sample Order.'], 500);
        }
    }

    public function indexConvertVisitAndQuote($id, Request $request)
    {
        $type = $request->query('type');
        $data = $this->getDropDownData();
        $sampleOrder = SampleOrder::findOrFail($id);
        $opportunity = $sampleOrder->opportunities;
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
        $sampleOrderProducts = SampleOrderProduct::with(['product.unit_measure'])->where('sample_order_id', $id)->get();
        $sampleOrderServices = SampleOrderService::with(['service.unit_measure'])->where('sample_order_id', $id)->get();
        if ($type == 'visit') {
            return view('opportunity.opportunity_convert.sample_order_converts.visit', compact('data', 'sampleOrder', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'taxAmount', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator', 'designer', 'builder', 'sampleOrderProducts', 'sampleOrderServices'));
        } else if ($type == 'quote') {
            return view('opportunity.opportunity_convert.sample_order_converts.quote', compact('data', 'sampleOrder', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'taxAmount', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator', 'designer', 'builder', 'sampleOrderProducts', 'sampleOrderServices'));
        }
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
        $quoteFooter = QuoteFooter::query()->pluck('quote_footer_name', 'id');
        $quoteHeader = QuoteHeader::query()->pluck('quote_header_name', 'id');
        $quotePrintedNote = QuotePrintedNote::query()->pluck('quote_printed_notes_name', 'id');
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'endUseSegments', 'projectTypes', 'opportunityStages', 'aboutUsOptions', 'probabilityCloses', 'eventTypes', 'productTypes', 'productCategories', 'suppliers', 'services', 'documentFooters', 'quoteFooter', 'quoteHeader', 'quotePrintedNote');
    }

    public function getSampleOrderDataTableList(Request $request)
    {
        return $this->sampleOrderRepository->dataTableSampleOrder($request);
    }

    public function getAllSampleOrderDataTableList(Request $request, $id)
    {
        return $this->sampleOrderRepository->dataTableSampleOrderAll($request, $id);
    }
}
