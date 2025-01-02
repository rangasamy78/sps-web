<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Visit;
use App\Models\County;
use App\Models\Service;
use App\Models\TaxCode;
use App\Models\Company;
use App\Models\Product;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\FileType;
use App\Models\EventType;
use App\Models\Associate;
use App\Models\Opportunity;
use App\Models\ProjectType;
use App\Models\ProductType;
use App\Models\VisitProduct;
use App\Models\VisitService;
use Illuminate\Http\Request;
use App\Models\VisitContact;
use App\Models\TaxComponent;
use App\Models\ProductPrice;
use App\Models\CustomerType;
use App\Models\EndUseSegment;
use App\Models\AboutUsOption;
use App\Models\PriceListLabel;
use App\Models\ProductCategory;
use App\Models\OpportunityStage;
use App\Models\ProbabilityToClose;
use Illuminate\Support\Facades\DB;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\VisitRepository;
use App\Repositories\OpportunityRepository;
use App\Http\Requests\Visit\{CreateVisitRequest, UpdateVisitRequest};
use App\Http\Requests\Visit\Opportunity\UpdateOpportunityVisitRequest;
use App\Http\Requests\Visit\VisitProduct\{CreateVisitProductRequest, UpdateVisitProductRequest};
use App\Http\Requests\Visit\VisitService\{CreateVisitServiceRequest, UpdateVisitServiceRequest};
use App\Http\Requests\Opportunity\{CreateOpportunityRequest, UpdateOpportunityRequest};

class VisitController extends Controller
{
    private VisitRepository $visitRepository;
    private OpportunityRepository $opportunityRepository;
    public function __construct(VisitRepository $visitRepository, OpportunityRepository $opportunityRepository)
    {
        $this->opportunityRepository = $opportunityRepository;
        $this->visitRepository = $visitRepository;
    }

    public function index()
    {
        // return view('visit.create.__create_visits');
    }
    public function getOpportunityDetail($id)
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

        return view('visit.create.__create_visits', compact('data', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator'));
    }

    public function store(CreateVisitRequest $request)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $visit = $this->visitRepository->store($request->only('opportunity_id', 'visit_label', 'visit_date', 'visit_time', 'sales_person_id', 'price_level_id', 'visit_printed_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Visit saved successfully.', 'visit_id' => $visit->id]);
        } catch (Exception $e) {
            Log::error('Error saving Visit: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Visit.']);
        }
    }

    public function showAddProduct($id)
    {
        $data = $this->getDropDownData();
        $visit = Visit::findOrFail($id);
        $opportunity = $visit->opportunities;
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $company = $opportunity?->location;
        $price_list = $opportunity?->price_list;
        $customer = $opportunity?->customer;
        $primary_sales = $opportunity?->primary_user;
        $secondary_sales = $opportunity?->secondary_user;
        $taxCode = $opportunity?->sales_tax;
        $taxAmount = $taxCode?->tax_code_component()->first();
        return view('visit.create.__create_visit_products', compact(
            'data',
            'visit',
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

    // public function searchProduct(Request $request)
    // {
    //     return $this->visitRepository->searchProductDataTable($request);
    // }

    // public function getProduct(Request $request)
    // {
    //     try {
    //         $id = $request->get('id');
    //         $product = Product::with('price')->findOrFail($id);
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $product,
    //         ]);
    //     } catch (Exception $e) {
    //         Log::error('Error in searchProduct: ' . $e->getMessage());
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'An error occurred while fetching products.',
    //         ], 500);
    //     }
    // }

    // public function getProductPrice(Request $request)
    // {
    //     try {
    //         $id = $request->get('id');
    //         $product = Product::findOrFail($id);
    //         $price = ProductPrice::where('product_id', $product->id)->firstOrFail();
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $price
    //         ]);
    //     } catch (Exception $e) {
    //         Log::error('Error in searchProduct: ' . $e->getMessage());
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'An error occurred while fetching products.',
    //         ], 500);
    //     }
    // }

    public function saveVisitProduct(Request $request, CreateVisitProductRequest $createVisitProductRequest, CreateVisitServiceRequest $createVisitServiceRequest)
    {
        DB::beginTransaction();  // Start the transaction
        try {
            $validated = $createVisitProductRequest->validated();
            $validatedService = $createVisitServiceRequest->validated();

            $visit = Visit::findOrFail($request->input('visit_id'));
            $visit->update([
                'visit_printed_notes' => $request->input('visit_printed_notes'),
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
            // Prepare products data for bulk insert
            VisitProduct::where('visit_id', $visit->id)->delete();
            $productsData = [];
            if (!empty($validated['product_id'])) {
                foreach ($validated['product_id'] as $key => $product) {
                    if ($product) {
                        $productsData[] = [
                            'product_id' => $product ?? null,
                            'is_sold_as' => $validated['is_sold_as'][$key] ?? false,
                            'product_description' => $validated['product_description'][$key] ?? null,
                            'product_quantity' => $validated['product_quantity'][$key] ?? null,
                            'product_unit_price' => $validated['product_unit_price'][$key] ?? null,
                            'product_amount' => $validated['product_amount'][$key] ?? null,
                        ];
                    }
                }
            }
            // Bulk insert visit products
            if (!empty($productsData)) {
                $visit->products()->createMany($productsData);
            }
            // Prepare services data for bulk insert
            VisitService::where('visit_id', $visit->id)->delete();
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
            // Bulk insert visit services if any
            if (!empty($servicesData)) {
                $visit->services()->createMany($servicesData);
            }
            // Commit the transaction if everything is fine
            DB::commit();

            return response()->json([
                'status' => 'success',
                'msg' => 'Visit data saved successfully.',
            ]);
        } catch (Exception $e) {
            // Log the error message for debugging
            Log::error('Error saving visit data', ['error' => $e->getMessage()]);
            // Rollback transaction in case of error
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function editVisitProduct($id)
    {
        $data = $this->getDropDownData();
        $visit = Visit::findOrFail($id);
        $visitProducts = VisitProduct::join('products', 'visit_products.product_id', '=', 'products.id')
            ->where('visit_products.visit_id', $id)
            ->select('visit_products.*', 'products.product_name')
            ->get();
        $visitServices = VisitService::join('services', 'visit_services.service_id', '=', 'services.id')
            ->where('visit_services.visit_id', $id)
            ->select('visit_services.*', 'services.service_name')
            ->get();
        $opportunity = Opportunity::findOrFail($visit->opportunity_id);
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
        return view('visit.edit.__edit_visit_products', compact(
            'data',
            'visit',
            'visitProducts',
            'visitServices',
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

    public function updateVisitProduct(Request $request, UpdateVisitServiceRequest $updateVisitServiceRequest, UpdateVisitProductRequest $updateVisitProductRequest)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('visit_id');
            $visit = Visit::findOrFail($id);
            // Update visit data
            $visit->update([
                'visit_printed_notes' => $request->input('visit_printed_notes'),
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
            $validated = $updateVisitProductRequest->validated();
            VisitProduct::where('visit_id', $visit->id)->delete(); // Delete existing products
            if (!empty($validated['product_id'])) {
                foreach ($validated['product_id'] as $key => $product) {
                    if ($product) {
                        VisitProduct::create([
                            'visit_id' => $visit->id,
                            'product_id' => $product,
                            'is_sold_as' => $validated['is_sold_as'][$key] ?? false,
                            'product_description' => $validated['product_description'][$key] ?? null,
                            'product_quantity' => $validated['product_quantity'][$key] ?? null,
                            'product_unit_price' => $validated['product_unit_price'][$key] ?? null,
                            'product_amount' => $validated['product_amount'][$key] ?? null,
                        ]);
                    }
                }
            }

            // Update services
            $validatedService = $updateVisitServiceRequest->validated();
            VisitService::where('visit_id', $visit->id)->delete(); // Delete existing services
            if (!empty($validatedService['service_id'])) {
                foreach ($validatedService['service_id'] as $key => $service) {
                    if ($service) {
                        VisitService::create([
                            'visit_id' => $visit->id,
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
                'msg' => 'Visit Updated saved successfully.',
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

    public function deleteVisitProduct($id)
    {
        try {
            $visitProduct = VisitProduct::findOrFail($id);
            if ($visitProduct) {
                $visitProduct->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Visit Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Visit Product not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Visit Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Visit Product.']);
        }
    }

    public function show($id)
    {
        $data = $this->getDropDownData();
        $visit = Visit::findOrFail($id);
        $opportunity = Opportunity::findOrFail($visit->opportunity_id);
        $visits = Visit::where('opportunity_id', $visit->opportunity_id)
            ->orderBy('created_at', 'asc')
            ->get();
        $position = $visits->search(function ($item) use ($id) {
            return $item->id == $id;
        }) + 1;
        $visit_count = Visit::where('opportunity_id', $visit->opportunity_id)->count();
        $visit_date = $visit->created_at ? \Carbon\Carbon::parse($visit->created_at)->format('M d Y g:iA') : null;
        $opportunity_date = $opportunity->created_at ? \Carbon\Carbon::parse($opportunity->created_at)->format('M d Y g:iA') : null;
        $company = optional(Company::find($opportunity->location_id));
        $price_list = optional(PriceListLabel::find($opportunity->price_level_label_id));
        $customer = optional(Customer::find($opportunity->billing_customer_id));
        $primary_sales = optional(User::find($opportunity->primary_sales_person_id));
        $secondary_sales = optional(User::find($opportunity->secondary_sales_person_id));
        $loginPerson = optional(User::find($opportunity->login_user_id));
        $taxCode = optional(TaxCode::find($opportunity->sales_tax_id));
        $taxAmount = $taxCode ? TaxComponent::where('tax_code_id', $taxCode->id)->first() : null;
        $fabricator = Associate::find($opportunity->fabricator_id);
        $designer = Associate::find($opportunity->designer_id);
        $builder = Associate::find($opportunity->builder_id);
        $howDidHear = $opportunity->how_did_hear_about_us_id ? AboutUsOption::find($opportunity->how_did_hear_about_us_id) : null;
        $fileTypes = FileType::where('view_in', 'Transaction')->select('id', 'file_Type')->get();
        $visitContacts = VisitContact::where('visit_id', $id)
            ->with('contact')
            ->get();
        $contacts = $visitContacts->map(function ($visitContacts) {
            return [
                'name' => optional($visitContacts->contact)->contact_name ?? 'Unknown Contact',
                'visit_contact_id' => $visitContacts->id,
            ];
        });
        return view('visit.show.__show', compact(
            'data',
            'visit',
            'opportunity',
            'position',
            'visit_date',
            'opportunity_date',
            'company',
            'price_list',
            'customer',
            'primary_sales',
            'secondary_sales',
            'taxCode',
            'taxAmount',
            'loginPerson',
            'fabricator',
            'designer',
            'builder',
            'howDidHear',
            'visit_count',
            'fileTypes',
            'contacts'
        ));
    }

    public function edit($id)
    {
        $data = $this->getDropDownData();
        $visit = Visit::findOrFail($id);
        $opportunity = $visit->opportunities;
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
        return view('visit.edit.__edit_visits', compact('data', 'visit', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator'));
    }

    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        try {
            $opportunity = Opportunity::findOrFail($request->opportunity_id);
            $opportunity->update([
                'internal_notes' => $request->input('internal_notes'),
                'special_instructions' => $request->input('special_instructions'),
            ]);
            $this->visitRepository->update($request->only('opportunity_id', 'visit_label', 'visit_date', 'visit_time', 'sales_person_id', 'price_level_id', 'visit_printed_notes'), $visit->id);
            return response()->json(['status' => 'success', 'msg' => 'Visit Updated successfully.', 'visit_id' => $visit->id]);
        } catch (Exception $e) {
            Log::error('Error updating Visit: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Visit.']);
        }
    }

    public function updateProbabilityClose(Request $request, $id)
    {
        try {
            $visit = Visit::findOrFail($id);
            $visit->probability_close_id = $request->input('probability_close_id');
            $visit->save();
            return response()->json(['status' => 'success', 'msg' => 'Visit Probability close updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating visit probability close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating visit probability close.']);
        }
    }

    public function updateCheckout(Request $request, $id)
    {
        try {
            $visit = Visit::findOrFail($id);
            $visit->checkout = 1;
            $visit->updated_at = now();
            $visit->save();
            $createdAt = \Carbon\Carbon::parse($visit->created_at);
            $updatedAt = \Carbon\Carbon::parse($visit->updated_at);
            $timeDifference = $updatedAt->diffForHumans($createdAt, true); // e.g., "2 hours 30 minutes"
            $updatedTime = $updatedAt->format('h:i A'); // Format updated time
            return response()->json([
                'status' => 'success',
                'msg' => 'Checkout updated successfully.',
                'updated_time' => $updatedTime,
                'time_difference' => $timeDifference,
            ]);
        } catch (Exception $e) {
            Log::error('Error updating Checkout: ' . $e->getMessage());
            return response()->json([
                'status' => 'false',
                'msg' => 'An error occurred while updating Checkout.',
            ]);
        }
    }

    public function updateSurveyRate(Request $request, $id)
    {
        try {
            $visit = Visit::findOrFail($id);
            $visit->survey_rating = $request->input('survey_rating');
            $visit->save();
            return response()->json(['status' => 'success', 'msg' => 'Survey Rating updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Survey Rating: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Survey Rating.']);
        }
    }

    public function destroy($id)
    {
        try {
            $Visit = $this->visitRepository->findOrFail($id);
            $this->visitRepository->delete($id);
            VisitProduct::where('visit_id', $id)->delete();
            VisitService::where('visit_id', $id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Visit deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting visit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the visit.'], 500);
        }
    }

    //visit create through oppportunity
    public function indexOpportunityVisit()
    {
        $data = $this->getDropDownData();
        $count = Opportunity::count();
        return view('visit.create.__create_oppotunity_visits', compact('data', 'count'));
    }

    public function saveOpportunityVisit(Request $request, CreateOpportunityRequest $requestOpportunity)
    {
        try {
            $opportunityData = $requestOpportunity->only('opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id');
            $opportunity = $this->opportunityRepository->store($opportunityData);
            $visitData = [
                'visit_date' => now()->format('Y-m-d'),
                'visit_time' => now()->format('h:i:s A'),
                'opportunity_id' => $opportunity->id,
                'price_level_id' => $request->input('price_level_label_id'),
            ];
            $visit = $this->visitRepository->store($visitData);
            return response()->json([
                'status' => 'success',
                'msg' => 'Opportunity and visit saved successfully.',
                'visit_id' => $visit->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving opportunity or visit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the opportunity or visit. Please try again.',
            ], 500);
        }
    }

    public function editOpportunityVisit($id)
    {
        $data = $this->getDropDownData();
        $visit = Visit::findOrFail($id);
        $opportunity = $visit->opportunities;
        $billCustomer = $opportunity?->customer;
        $fabricator = $opportunity?->fabricator;
        $designer = $opportunity?->designer;
        $builder = $opportunity?->builder;
        return view('visit.edit.__edit_oppotunity_visits', compact('data', 'visit', 'opportunity', 'billCustomer', 'fabricator', 'designer', 'builder'));
    }
    public function updateOpportunityVisit(Request $request, $id, UpdateOpportunityVisitRequest $updateOpportunityVisitRequest)
    {
        try {
            $visitData = [
                'visit_date' => now()->toDateString(),
                'visit_time' => now()->toTimeString(),
                'opportunity_id' => $request->input('opportunity_id'),
                'price_level_id' => $request->input('price_level_label_id'),
                'visit_label' => $request->input('visit_label'),
                'visit_printed_notes' => $request->input('visit_printed_notes'),
            ];
            $visit_id = $request->input('visit_id');
            $this->visitRepository->update($visitData, $visit_id);
            $opportunityData = $updateOpportunityVisitRequest->only(['opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id']);
            $this->opportunityRepository->update($opportunityData, $id);
            return response()->json([
                'status' => 'success',
                'msg' => 'Opportunity and visit updated successfully.',
                'visit_id' => $visit_id,
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

    public function getVisitProductDataTableList(Request $request, $id)
    {
        return $this->visitRepository->dataTable($request, $id);
    }

    public function getVisitDataTableList(Request $request)
    {
        return $this->visitRepository->dataTableVisit($request);
    }

    public function getAllVisitDataTableList(Request $request, $id)
    {
        return $this->visitRepository->dataTableVisitAll($request, $id);
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
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'endUseSegments', 'projectTypes', 'opportunityStages', 'aboutUsOptions', 'probabilityCloses', 'eventTypes', 'productTypes', 'productCategories', 'suppliers', 'services');
    }
}
