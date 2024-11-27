<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Visit;
use App\Models\Service;
use App\Models\TaxCode;
use App\Models\Company;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Associate;
use App\Models\Opportunity;
use App\Models\ProjectType;
use App\Models\ProductType;
use App\Models\VisitProduct;
use App\Models\VisitService;
use Illuminate\Http\Request;
use App\Models\TaxComponent;
use App\Models\ProductPrice;
use App\Models\EndUseSegment;
use App\Models\AboutUsOption;
use App\Models\PriceListLabel;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\VisitRepository;
use App\Http\Requests\Visit\{CreateVisitRequest, UpdateVisitRequest};
use App\Http\Requests\Visit\VisitProduct\{CreateVisitProductRequest, UpdateVisitProductRequest};
use App\Http\Requests\Visit\VisitService\{CreateVisitServiceRequest, UpdateVisitServiceRequest};

class VisitController extends Controller
{
    private VisitRepository $visitRepository;

    public function __construct(VisitRepository $visitRepository)
    {
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
        $customer = Customer::find($opportunity->billing_customer_id);
        $opportunity_date = $opportunity->updated_at ? \Carbon\Carbon::parse($opportunity->updated_at)->format('M d Y g:iA') : null;
        $taxcode = $opportunity->sales_tax_id ? TaxCode::find($opportunity->sales_tax_id) : null;
        $price_list = PriceListLabel::find($opportunity->price_level_label_id);
        $payment_term = $customer ? AccountPaymentTerm::find($customer->payment_terms_id) : null;
        $endUseSegment = EndUseSegment::findOrFail($opportunity->end_use_segment_id);
        $howDidHear = $opportunity->how_did_hear_about_us_id ? AboutUsOption::find($opportunity->how_did_hear_about_us_id) : null;
        $projectType = $opportunity->project_type_id ? ProjectType::findOrFail($opportunity->project_type_id) : null;
        $company = $opportunity ? Company::find($opportunity->location_id) : null;
        $primarySale = $opportunity->primary_sales_person_id ? User::find($opportunity->primary_sales_person_id) : null;
        $secondarySale = $opportunity->secondary_sales_person_id ? User::find($opportunity->secondary_sales_person_id) : null;
        $fabricator = Associate::find($opportunity->fabricator_id);
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

    public function searchProduct(Request $request)
    {
        return $this->visitRepository->searchProductDataTable($request);
    }

    public function getProduct(Request $request)
    {
        try {
            $id = $request->get('id');
            $product = Product::with('price')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $product,
            ]);
        } catch (Exception $e) {
            Log::error('Error in searchProduct: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching products.',
            ], 500);
        }
    }

    public function getProductPrice(Request $request)
    {
        try {
            $id = $request->get('id');
            $product = Product::findOrFail($id);
            $price = ProductPrice::where('product_id', $product->id)->firstOrFail();
            return response()->json([
                'status' => 'success',
                'data' => $price
            ]);
        } catch (Exception $e) {
            Log::error('Error in searchProduct: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching products.',
            ], 500);
        }
    }

    public function saveVisitProduct(
        Request $request,
        CreateVisitProductRequest $createVisitProductRequest,
        CreateVisitServiceRequest $createVisitServiceRequest
    ) {
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
        $company = $opportunity ? Company::find($opportunity->location_id) : null;
        $price_list = PriceListLabel::find($opportunity->price_level_label_id);
        $customer = Customer::find($opportunity->billing_customer_id);
        $primary_sales = optional(User::find($opportunity->primary_sales_person_id));
        $secondary_sales = optional(User::find($opportunity->secondary_sales_person_id));
        $taxCode = TaxCode::find($opportunity->sales_tax_id);
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
        DB::beginTransaction();  // Start the transaction
        try {
            dd($request->all());
            $id = $request->input('visit_id');
            $visit = Visit::findOrFail($id);

            // Update visit data
            $visit->update([
                'visit_printed_notes' => $request->input('visit_printed_notes'),
            ]);

            // Update opportunity
            $opportunity = Opportunity::findOrFail($request->input('opportunity_id'));
            $opportunity->update([
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
                'msg' => 'Visit data saved successfully.',
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
        return view('visit.show.__show', compact(
            'data',
            'visit',
            'opportunity',
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
            'visit_count'
        ));
    }

    public function edit(Visit $visit)
    {
        //
    }

    public function update(Request $request, Visit $visit)
    {
        //
    }

    public function destroy(Visit $visit)
    {
        //
    }

    public function getVisitProductDataTableList(Request $request, $id)
    {
        return $this->visitRepository->dataTable($request, $id);
    }
    public function getDropDownData()
    {
        $companies = Company::query()->select('id', 'company_name')->get();
        $paymentTerms = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $users = User::query()->select(DB::raw("CONCAT(first_name, ' - ', last_name) as name"), 'id')->pluck('name', 'id');
        $customers = Customer::query()->select('id', 'customer_name', 'customer_code', 'mobile', 'address')->get();
        $customerCount = Customer::query()->count();
        $associates = Associate::query()->select('id', 'associate_name')->get();
        $priceListLabels     = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        $salesTaxs           = TaxCode::query()->select(DB::raw("CONCAT(tax_code, ' - ', tax_code_label) as tax_name"), 'id')->pluck('tax_name', 'id');
        $endUseSegments = EndUseSegment::query()->pluck('end_use_segment', 'id');
        $projectTypes = ProjectType::query()->pluck('project_type_name', 'id');
        $aboutUsOptions      = AboutUsOption::query()->pluck('how_did_you_hear_option', 'id');
        $productTypes = ProductType::query()->pluck('product_type', 'id');
        $productCategories = ProductCategory::query()->pluck('product_category_name', 'id');
        $suppliers = Supplier::query()->pluck('supplier_name', 'id');
        $services = Service::query()->pluck('service_name', 'id');
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels',  'customers', 'customerCount', 'associates', 'salesTaxs', 'endUseSegments', 'projectTypes',  'aboutUsOptions', 'productTypes', 'productCategories', 'suppliers', 'services');
    }
}
