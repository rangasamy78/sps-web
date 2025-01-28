<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Hold;
use App\Models\User;
use App\Models\Quote;
use App\Models\Visit;
use App\Models\County;
use App\Models\Company;
use App\Models\Account;
use App\Models\TaxCode;
use App\Models\Country;
use App\Models\Service;
use App\Models\FileType;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Associate;
use App\Models\EventType;
use App\Models\Opportunity;
use App\Models\ServiceType;
use App\Models\ProductType;
use App\Models\HoldContact;
use App\Models\HoldProduct;
use App\Models\HoldService;
use App\Models\ProjectType;
use App\Models\SampleOrder;
use Illuminate\Http\Request;
use App\Models\CustomerType;
use App\Models\TaxComponent;
use App\Models\ProductGroup;
use App\Models\AboutUsOption;
use App\Models\EndUseSegment;
use App\Models\PaymentMethod;
use App\Models\PriceListLabel;
use App\Models\ServiceCategory;
use App\Models\ProductCategory;
use App\Models\OpportunityStage;
use App\Models\ProductPriceRange;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Models\AccountPaymentTerm;
use App\Models\ProbabilityToClose;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\HoldRepository;
use App\Repositories\OpportunityRepository;
use App\Http\Requests\Hold\{CreateHoldRequest, UpdateHoldRequest};
use App\Http\Requests\Opportunity\CreateOpportunityRequest;
use App\Http\Requests\Hold\HoldProduct\CreateHoldProductRequest;
use App\Http\Requests\Hold\HoldService\CreateHoldServiceRequest;

class HoldController extends Controller
{
    private HoldRepository $holdRepository;
    private OpportunityRepository $opportunityRepository;
    public function __construct(HoldRepository $holdRepository, OpportunityRepository $opportunityRepository)
    {
        $this->holdRepository = $holdRepository;
        $this->opportunityRepository = $opportunityRepository;
    }

    public function indexHold($id)
    {
        $data = $this->getDropDownData();
        $opportunity = Opportunity::findOrFail($id);
        $holdCount = Hold::count();
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
        $designer = $opportunity?->designer;
        $builder = $opportunity?->builder;
        return view('hold.create.__create_holds', compact('data', 'opportunity', 'holdCount', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator', 'designer', 'builder'));
    }

    public function indexProductHold($id)
    {
        $data = $this->getDropDownData();
        $hold = Hold::findOrFail($id);
        $opportunity = $hold->opportunities;
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $company = $hold?->location;
        $priceList = $hold?->price_list;
        $customer = $hold?->customer;
        $primary_sales = $hold?->primary_user;
        $secondary_sales = $hold?->secondary_user;
        $paymentTerm = $hold?->payment_term;
        $taxCode = $hold?->sales_tax;
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        return view('hold.create.__create_hold_products', compact(
            'data',
            'hold',
            'opportunity',
            'company',
            'priceList',
            'customer',
            'primary_sales',
            'secondary_sales',
            'paymentTerm',
            'taxCode',
            'taxAmount'
        ));
    }

    public function saveHoldProduct(Request $request, CreateHoldProductRequest $createHoldProductRequest, CreateHoldServiceRequest $createHoldServiceRequest)
    {
        DB::beginTransaction();
        try {
            $validated = $createHoldProductRequest->validated();
            $validatedService = $createHoldServiceRequest->validated();

            $hold = Hold::findOrFail($request->input('hold_id'));
            $hold->update([
                'total' => $request->input('total'),
            ]);
            HoldProduct::where('hold_id', $hold->id)->delete();
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
            if (!empty($productsData)) {
                $hold->hold_products()->createMany($productsData);
            }
            HoldService::where('hold_id', $hold->id)->delete();
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
                $hold->hold_services()->createMany($servicesData);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'msg' => 'Hold data saved successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error saving Hold data', ['error' => $e->getMessage()]);
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function editHoldProduct($id)
    {
        $data = $this->getDropDownData();
        $hold = Hold::findOrFail($id);
        $opportunity = $hold->opportunities;
        $holdProducts = HoldProduct::join('products', 'hold_products.product_id', '=', 'products.id')
            ->where('hold_products.hold_id', $id)
            ->select('hold_products.*', 'products.product_name')
            ->get();
        $holdServices = HoldService::join('services', 'hold_services.service_id', '=', 'services.id')
            ->where('hold_services.hold_id', $id)
            ->select('hold_services.*', 'services.service_name')
            ->get();
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $company = $hold?->location;
        $priceList = $hold?->price_list;
        $customer = $hold?->customer;
        $primary_sales = $hold?->primary_user;
        $secondary_sales = $hold?->secondary_user;
        $paymentTerm = $hold?->payment_term;
        $taxCode = $hold?->sales_tax;
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        return view('hold.edit.__edit_hold_products', compact('data', 'hold', 'opportunity', 'holdProducts', 'holdServices', 'opportunity_date', 'company', 'priceList', 'customer', 'primary_sales', 'secondary_sales', 'paymentTerm', 'taxCode', 'taxAmount'));
    }

    public function deleteHoldProduct($id)
    {
        try {
            $holdProduct = HoldProduct::findOrFail($id);
            if ($holdProduct) {
                $holdProduct->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Hold Product deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Hold Product not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Hold Product: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Hold Product.']);
        }
    }

    public function store(CreateHoldRequest $request)
    {
        try {
            $hold = $this->holdRepository->store($request->only('opportunity_id', 'hold_code', 'hold_date', 'hold_time', 'expiry_date', 'customer_po', 'project_type_id', 'location_id', 'pick_ticket_restriction', 'billing_customer_id', 'bill_to_attn', 'bill_to_fax', 'bill_to_mobile', 'payment_term_id', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'sales_tax_id', 'hold_label', 'job_name', 'attn', 'address', 'suite', 'city', 'state', 'zip', 'country_id', 'phone', 'fax', 'mobile', 'email', 'delivery_type_id', 'how_did_hear_about_us_id', 'fabricator_id', 'designer_id', 'general_contractor_id', 'builder_id', 'brand_id', 'referred_by_id', 'instructions', 'internal_notes', 'printed_notes', 'probability_to_close_id'));
            return response()->json(['status' => 'success', 'msg' => 'Hold saved successfully.', 'hold_id' => $hold->id]);
        } catch (Exception $e) {
            Log::error('Error saving Hold: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Hold.']);
        }
    }

    public function show($id)
    {
        $data = $this->getDropDownData();
        $hold = Hold::findOrFail($id);
        $opportunity = Opportunity::findOrFail($hold->opportunity_id);
        $holds = Hold::where('opportunity_id', $hold->opportunity_id)->orderBy('created_at', 'asc')->get();
        $position = $holds->search(function ($item) use ($id) {
            return $item->id == $id;
        }) + 1;
        $holdCount = Hold::where('opportunity_id', $hold->opportunity_id)->count();
        $quoteCount = Quote::where('opportunity_id', $hold->opportunity_id)->count();
        $sampleOrderCount = SampleOrder::where('opportunity_id', $hold->opportunity_id)->count();
        $visitCount = Visit::where('opportunity_id', $hold->opportunity_id)->count();
        $holdDate = $hold->created_at ? \Carbon\Carbon::parse($hold->created_at)->format('M d Y g:iA') : null;
        $releaseDate = $hold->release_date ? \Carbon\Carbon::parse($hold->release_date)->format('M d Y') : null;
        $opportunity_date = $opportunity->created_at ? \Carbon\Carbon::parse($opportunity->created_at)->format('M d Y g:iA') : null;
        $opportunityStage = $opportunity->opportunity_stage;

        $company = $hold?->location;
        $priceList = $hold?->price_list;
        $customer = $opportunity?->customer;
        $primarySale = $hold?->primary_user;
        $secondarySale = $hold?->secondary_user;
        $loginPerson = optional(User::find($opportunity->login_user_id));
        $taxCode = $hold?->sales_tax;
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        $fabricator = $hold?->fabricator;
        $designer = $hold?->designer;
        $builder = $hold?->builder;
        $generalConstructor = $hold?->general_contractor;
        $brand = $hold?->brand;
        $referredBy = $hold?->referred_by;
        $howDidHear = $hold?->how_did_you_hear;
        $fileTypes = FileType::where('view_in', 'Transaction')->where('file_type_saleorder', '1')->select('id', 'file_Type')->get();
        $expiryDate = Carbon::createFromFormat('Y-m-d', $hold->expiry_date); // Ensure $hold->expiry_date is in 'Y-m-d' format
        $currentDate = Carbon::now();

        $expiryDay = ''; // Initialize the variable to store the expiration message

        if ($currentDate->greaterThan($expiryDate)) {
            $daysExpired = $currentDate->diffInDays($expiryDate);
            if ($daysExpired != 0) {
                $expiryDay = "Expired on " . $expiryDate->format('M d, Y') . " ({$daysExpired} Days Ago)";
            } else {
                $expiryDay = "Expires today on " . $expiryDate->format('M d, Y');
            }
        } else {
            $daysRemaining = $expiryDate->diffInDays($currentDate);
            $expiryDay = "Expires on " . $expiryDate->format('M d, Y') . " (in {$daysRemaining} days)";
        }
        $paymentTerm = $hold->payment_term;
        $holdContacts = HoldContact::where('hold_id', $id)
            ->with('contact')
            ->get();
        $contacts = $holdContacts->map(function ($holdContacts) {
            return [
                'name' => optional($holdContacts->contact)->contact_name ?? 'Unknown Contact',
                'hold_contact_id' => $holdContacts->id,
            ];
        });
        return view('hold.show.__show', compact('data', 'hold', 'opportunity', 'position', 'holdCount', 'quoteCount', 'holdDate', 'releaseDate', 'opportunity_date', 'opportunityStage', 'company', 'priceList', 'customer', 'primarySale', 'secondarySale', 'taxCode', 'taxAmount', 'loginPerson', 'fabricator', 'designer', 'builder', 'generalConstructor', 'brand', 'referredBy', 'howDidHear', 'sampleOrderCount', 'visitCount', 'fileTypes', 'expiryDay', 'paymentTerm', 'contacts'));
    }

    public function updateProbabilityClose(Request $request, $id)
    {
        try {
            $hold = hold::findOrFail($id);
            $hold->probability_to_close_id = $request->input('probability_to_close_id');
            $hold->save();
            return response()->json(['status' => 'success', 'msg' => 'Hold Probability close updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Hold probability close: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Hold probability close.']);
        }
    }

    public function updateInternalNotes(Request $request, $id)
    {
        try {
            $hold = Hold::findOrFail($id);
            $existingNotes = $hold->internal_notes ?? '';
            $newNotes = $request->input('internal_notes');
            $hold->internal_notes = $existingNotes . "\n" . $newNotes;
            $hold->save();
            return response()->json([
                'status' => 'success',
                'msg' => 'Quote Internal notes updated successfully.',
                'data' => $hold->internal_notes
            ]);
        } catch (Exception $e) {
            Log::error('Error updating Quote Internal notes: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Quote Internal notes.']);
        }
    }

    public function updateSurveyRate(Request $request, $id)
    {
        try {
            $hold = Hold::findOrFail($id);
            $hold->survey_rating = $request->input('survey_rating');
            $hold->save();
            return response()->json(['status' => 'success', 'msg' => 'Hold Survey Rating updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Hold Survey Rating: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Hold Survey Rating.']);
        }
    }

    public function indexHoldRelease($id)
    {
        $data = $this->getDropDownData();
        $hold = Hold::findOrFail($id);
        $holdDate = Carbon::parse($hold->hold_date)->format('M d, Y');
        $opportunity = $hold->opportunities;
        $location = $hold->location;
        $primaryPerson = $hold->primary_user;
        $customer = $hold->customer;
        $holdProducts = HoldProduct::join('products', 'hold_products.product_id', '=', 'products.id')
            ->where('hold_products.hold_id', $id)
            ->select('hold_products.*', 'products.product_name')
            ->get();
        $holdServices = HoldService::join('services', 'hold_services.service_id', '=', 'services.id')
            ->where('hold_services.hold_id', $id)
            ->select('hold_services.*', 'services.service_name')
            ->get();
        $taxCode = $hold?->sales_tax;
        $taxAmount = null;
        if ($taxCode) {
            $taxAmount = TaxComponent::where('tax_code_id', $taxCode->id)->first();
        }
        return view('hold.release_hold.__release_holds', compact('data', 'hold', 'holdDate', 'opportunity', 'location', 'primaryPerson', 'customer', 'holdProducts', 'holdServices', 'taxCode', 'taxAmount'));
    }

    public function updateHoldRelease(Request $request)
    {
        DB::beginTransaction();
        try {
            $hold = Hold::findOrFail($request->input('hold_id'));
            $hold->update([
                'is_released' => $request->input('is_released'),
                'release_date' => $request->input('release_date'),
                'release_hold_reason' => $request->input('release_hold_reason'),
                'internal_notes' => $request->input('internal_notes'),
                'printed_notes' => $request->input('printed_notes'),
            ]);
            $productsData = $request->input('hold_products', []);
            if (is_string($productsData)) {
                $productsData = json_decode($productsData, true); // Decode JSON into an associative array
            }
            if (is_array($productsData)) {
                foreach ($productsData as $productData) {
                    if (!empty($productData['hold_product_id'])) {
                        HoldProduct::where('id', (int)$productData['hold_product_id'])
                            ->where('hold_id', $hold->id)
                            ->update([
                                'product_id' => $productData['product_id'] ?? null,
                                'product_quantity' => $productData['product_quantity'] ?? null,
                                'product_unit_price' => $productData['product_unit_price'] ?? null,
                                'product_amount' => $productData['product_amount'] ?? null,
                            ]);
                    } else {
                        $hold->hold_products()->create([
                            'product_id' => $productData['product_id'] ?? null,
                            'product_quantity' => $productData['product_quantity'] ?? null,
                            'product_unit_price' => $productData['product_unit_price'] ?? null,
                            'product_amount' => $productData['product_amount'] ?? null,
                        ]);
                    }
                }
            } else {
                Log::error('Expected array, received: ' . gettype($productsData));
            }
            $servicesData = $request->input('hold_services', []);
            if (is_string($servicesData)) {
                $servicesData = json_decode($servicesData, true); // Decode JSON into an associative array
            }

            if (is_array($servicesData)) {

                foreach ($servicesData as $serviceData) {
                    if (!empty($serviceData['hold_service_id'])) {
                        HoldService::where('id', (int)$serviceData['hold_service_id'])
                            ->where('hold_id', $hold->id)
                            ->update([
                                'service_id' => $serviceData['service_id'] ?? null,
                                'service_description' => $serviceData['service_description'] ?? null,
                                'service_quantity' => $serviceData['service_quantity'] ?? null,
                                'service_unit_price' => $serviceData['service_unit_price'] ?? null,
                                'service_amount' => $serviceData['service_amount'] ?? null,
                                'is_tax' => $serviceData['is_tax'] ?? false,
                            ]);
                    } else {
                        $hold->hold_services()->create([
                            'service_id' => $serviceData['service_id'] ?? null,
                            'service_description' => $serviceData['service_description'] ?? null,
                            'service_quantity' => $serviceData['service_quantity'] ?? null,
                            'service_unit_price' => $serviceData['service_unit_price'] ?? null,
                            'service_amount' => $serviceData['service_amount'] ?? null,
                            'is_tax' => $serviceData['is_tax'] ?? false,
                        ]);
                    }
                }
            } else {
                Log::error('Expected array for services, received: ' . gettype($servicesData));
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'msg' => 'Release Hold updated successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error updating Hold data', ['error' => $e->getMessage()]);
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while updating the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function indexOpportunityHold()
    {
        $data = $this->getDropDownData();
        $count = Opportunity::count();
        $holdCount = Hold::count();
        return view('hold.create.__create_oppotunity_holds', compact('data', 'count', 'holdCount'));
    }

    public function saveOpportunityHold(Request $request, CreateOpportunityRequest $requestOpportunity)
    {
        try {
            $opportunityData = $requestOpportunity->only('opportunity_code', 'opportunity_date', 'location_id', 'end_use_segment_id', 'project_type_id', 'opportunity_stage_id', 'contact_mode', 'billing_customer_id', 'attn', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'total_value', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'how_did_hear_about_us_id', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'probability_to_close_id', 'login_user_id');
            $opportunity = $this->opportunityRepository->store($opportunityData);
            $holdData = [
                'opportunity_id' => $opportunity->id,
                'hold_code' => $request->input('hold_code'),
                'hold_date' => $request->input('opportunity_date'),
                'hold_time' => now()->format('h:i:s A'),
                'expiry_date' => $request->input('expiry_date'),
                'customer_po' => $request->input('customer_po'),
                'project_type_id' => $request->input('project_type_id'),
                'location_id' => $request->input('location_id'),
                'pick_ticket_restriction' => $request->input('pick_ticket_restriction'),
                'billing_customer_id' => $request->input('billing_customer_id'),
                'bill_to_attn' => $request->input('attn'),
                'bill_to_fax' => $request->input('fax'),
                'bill_to_mobile' => $request->input('mobile'),
                'payment_term_id' => $request->input('payment_term_id'),
                'price_level_label_id' => $request->input('price_level_label_id'),
                'primary_sales_person_id' => $request->input('primary_sales_person_id'),
                'secondary_sales_person_id' => $request->input('secondary_sales_person_id'),
                'sales_tax_id' => $request->input('sales_tax_id'),
                'hold_label' => $request->input('hold_label'),
                'job_name' => $request->input('ship_to_job_name'),
                'attn' => $request->input('ship_to_attn'),
                'address' => $request->input('ship_to_address'),
                'suite' => $request->input('ship_to_suite'),
                'city' => $request->input('ship_to_city'),
                'state' => $request->input('ship_to_state'),
                'zip' => $request->input('ship_to_zip'),
                'country_id' => $request->input('ship_to_country_id'),
                'phone' => $request->input('ship_to_phone'),
                'fax' => $request->input('ship_to_fax'),
                'mobile' => $request->input('ship_to_mobile'),
                'email' => $request->input('ship_to_email'),
                'delivery_type' => $request->input('ship_to_type'),
                'how_did_hear_about_us_id' => $request->input('how_did_hear_about_us_id'),
                'fabricator_id' => $request->input('fabricator_id'),
                'designer_id' => $request->input('designer_id'),
                'builder_id' => $request->input('builder_id'),
                'instructions' => $request->input('special_instructions'),
                'internal_notes' => $request->input('internal_notes'),
                'printed_notes' => $request->input('printed_notes'),
            ];
            $hold = $this->holdRepository->store($holdData);
            return response()->json([
                'status' => 'success',
                'msg' => 'Opportunity and Hold saved successfully.',
                'hold_id' => $hold->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving opportunity or Hold: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'msg' => 'An error occurred while saving the opportunity or Hold. Please try again.',
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = $this->getDropDownData();
        $hold = Hold::findOrFail($id);
        $opportunity = $hold->opportunities;
        $customer = $hold?->customer;
        $opportunity_date = $opportunity?->created_at ? $opportunity->created_at->format('M d Y g:iA') : null;
        $taxcode = $hold?->sales_tax;
        $price_list = $hold?->price_list;
        $payment_term = $hold?->payment_term;
        $endUseSegment = $hold?->end_use_segment;
        $howDidHear = $hold?->how_did_you_hear;
        $projectType = $hold?->project_type;
        $company = $hold?->location;
        $primarySale = $hold?->primary_user;
        $secondarySale = $hold?->secondary_user;
        $fabricator = $hold?->fabricator;
        $designer = $hold?->designer;
        $builder = $hold?->builder;
        $generalContractor = $hold?->general_contractor;
        $brand = $hold?->brand;
        $referredBy = $hold?->referred_by;
        return view('hold.edit.__edit_holds', compact('data', 'hold', 'opportunity', 'customer', 'opportunity_date', 'taxcode', 'price_list', 'payment_term', 'endUseSegment', 'howDidHear', 'projectType', 'company', 'primarySale', 'secondarySale', 'fabricator', 'designer', 'builder', 'generalContractor', 'brand', 'referredBy'));
    }

    public function update(UpdateHoldRequest $request, Hold $hold)
    {
        try {
            $this->holdRepository->update($request->only('opportunity_id', 'hold_code', 'hold_date', 'hold_time', 'expiry_date', 'customer_po', 'project_type_id', 'location_id', 'pick_ticket_restriction', 'billing_customer_id', 'bill_to_attn', 'bill_to_fax', 'bill_to_mobile', 'payment_term_id', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'sales_tax_id', 'hold_label', 'job_name', 'attn', 'address', 'suite', 'city', 'state', 'zip', 'country_id', 'phone', 'fax', 'mobile', 'email', 'delivery_type_id', 'how_did_hear_about_us_id', 'fabricator_id', 'designer_id', 'general_contractor_id', 'builder_id', 'brand_id', 'referred_by_id', 'instructions', 'internal_notes', 'printed_notes', 'probability_to_close_id'), $hold->id);
            return response()->json(['status' => 'success', 'msg' => 'Hold Updated successfully.', 'hold_id' => $hold->id]);
        } catch (Exception $e) {
            Log::error('Error updating Hold: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Hold.']);
        }
    }

    public function getHoldProductDataTableList(Request $request, $id)
    {
        return $this->holdRepository->dataTable($request, $id);
    }

    public function getHoldDataTableList(Request $request)
    {
        return $this->holdRepository->dataTableHold($request);
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
        $productSubCategory = ProductSubCategory::query()->pluck('product_sub_category_name', 'id');
        $productPriceRange = ProductPriceRange::query()->pluck('product_price_range', 'id');
        $productGroup = ProductGroup::query()->pluck('product_group_name', 'id');
        $serviceType = ServiceType::query()->pluck('service_type', 'id');
        $serviceCategory = ServiceCategory::query()->pluck('service_category', 'id');
        $account = Account::query()->pluck('account_name', 'id');
        $paymentMethods = PaymentMethod::query()->pluck('payment_method_name', 'id');
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'endUseSegments', 'projectTypes', 'opportunityStages', 'aboutUsOptions', 'probabilityCloses', 'eventTypes', 'productTypes', 'productCategories', 'suppliers', 'services', 'productSubCategory', 'productPriceRange', 'productGroup', 'serviceType', 'serviceCategory', 'account', 'paymentMethods');
    }
}
