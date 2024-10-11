<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use App\Models\UnitMeasure;
use App\Models\ServiceType;
use App\Models\Expenditure;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Models\LinkedAccount;
use App\Models\ServiceCategory;
use App\Models\ProductPriceRange;
use Illuminate\Support\Facades\Log;
use App\Repositories\ServiceRepository;
use App\Http\Requests\Service\{ CreateServiceRequest, UpdateServiceRequest };

class ServiceController extends Controller
{
    private ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        $unit_measures          = UnitMeasure::all();
        $service_categories     = ServiceCategory::query()->get();
        $service_types          = ServiceType::query()->get();
        $product_groups         = ProductGroup::all();
        $linked_accounts        = LinkedAccount::query()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->account_code . ' - ' . $item->account_name];
            });
        $service_expenditures = Expenditure::all();
        $product_price_ranges = ProductPriceRange::all();
        return view('service.services', compact('unit_measures', 'service_categories', 'service_types', 'product_groups', 'linked_accounts', 'service_expenditures', 'product_price_ranges'));
    }

    public function create()
    {
        $unit_measures          = UnitMeasure::all();
        $service_categories     = ServiceCategory::query()->get();
        $service_types          = ServiceType::query()->get();
        $product_groups         = ProductGroup::all();
        $linked_accounts        = LinkedAccount::query()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->account_code . ' - ' . $item->account_name];
            });
        $service_expenditures = Expenditure::all();
        $product_price_ranges = ProductPriceRange::all();
        return view('service.__create', compact('unit_measures', 'service_categories', 'service_types', 'product_groups', 'linked_accounts', 'service_expenditures', 'product_price_ranges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        try {
            $serviceData = $request->only('service_name', 'service_sku', 'unit_of_measure_id', 'service_category_id', 'service_type_id', 'service_group_id', 'expenditure_id', 'avg_est_cost', 'gl_sales_account_id', 'gl_cost_of_sales_account_id', 'is_taxable_item', 'frequent_in_so', 'frequent_in_customer_cm', 'frequent_in_po', 'frequent_in_supplier_cm', 'notes', 'internal_instruction', 'disclaimer'
            );

            $serviceData['is_taxable_item']         = $request->has('is_taxable_item') ? 1 : 0;
            $serviceData['frequent_in_so']          = $request->has('frequent_in_so') ? 1 : 0;
            $serviceData['frequent_in_customer_cm'] = $request->has('frequent_in_customer_cm') ? 1 : 0;
            $serviceData['frequent_in_po']          = $request->has('frequent_in_po') ? 1 : 0;
            $serviceData['frequent_in_supplier_cm'] = $request->has('frequent_in_supplier_cm') ? 1 : 0;

            $priceData = $request->only(
                'homeowner_price', 'bundle_price', 'special_price', 'loose_slab_price', 'bundle_price_sqft',
                'special_price_per_sqft', 'owner_approval_price', 'loose_slab_per_slab', 'bundle_price_per_slab',
                'special_price_per_slab', 'owner_approval_price_per_slab', 'price12', 'price_range_id'
            );

            $data = [
                'serviceData' => $serviceData,
                'priceData'   => $priceData,
            ];

            $this->serviceRepository->store($data);

            return response()->json(['status' => 'success', 'msg' => 'Service saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving service: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the service.']);
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
        $service                    = Service::with('service_price')->findOrFail($id);
        $unit_measures              = UnitMeasure::query()->join('services', 'unit_measures.id', '=', 'services.unit_of_measure_id')->where('services.id', $id)->first();
        $service_categories         = ServiceCategory::query()->join('services', 'service_categories.id', '=', 'services.service_category_id')->where('services.id', $id)->first();
        $service_types              = ServiceType::query()->join('services', 'service_types.id', '=', 'services.service_type_id')->where('services.id', $id)->first();
        $product_groups             = ProductGroup::query()->join('services', 'product_groups.id', '=', 'services.service_group_id')->where('services.id', $id)->first();
        $gl_sales_accounts          = LinkedAccount::query()->join('services', 'linked_accounts.id', '=', 'services.gl_sales_account_id')->where('services.id', $id)->first();
        $gl_cost_of_sales_accounts  = LinkedAccount::query()->join('services', 'linked_accounts.id', '=', 'services.gl_cost_of_sales_account_id')->where('services.id', $id)->first();
        $service_expenditures       = Expenditure::query()->join('services', 'expenditures.id', '=', 'services.expenditure_id')->where('services.id', $id)->first();
        $product_price_ranges       = ProductPriceRange::all();
        return view('service.__show', compact('service', 'unit_measures', 'service_categories', 'service_types', 'product_groups', 'gl_sales_accounts','gl_cost_of_sales_accounts', 'service_expenditures', 'product_price_ranges'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $service                = Service::with('service_price')->findOrFail($id);
        $unit_measures          = UnitMeasure::all();
        $service_categories     = ServiceCategory::query()->get();
        $service_types          = ServiceType::query()->get();
        $product_groups         = ProductGroup::all();
        $linked_accounts        = LinkedAccount::query()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->account_code . ' - ' . $item->account_name];
            });
        $service_expenditures = Expenditure::all();
        $product_price_ranges = ProductPriceRange::all();
        return view('service.__edit', compact('service','unit_measures', 'service_categories', 'service_types', 'product_groups', 'linked_accounts', 'service_expenditures', 'product_price_ranges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        try {

            $data = [
                'serviceData' => $request->only(
                    'service_name', 'service_sku', 'unit_of_measure_id', 'service_category_id', 'service_type_id', 'service_group_id', 'expenditure_id', 'avg_est_cost', 'gl_sales_account_id', 'gl_cost_of_sales_account_id', 'is_taxable_item', 'frequent_in_so', 'frequent_in_customer_cm', 'frequent_in_po', 'frequent_in_supplier_cm', 'notes', 'internal_instruction', 'disclaimer'
            ),
                'priceData'   => $request->only(
                    'homeowner_price', 'bundle_price', 'special_price', 'loose_slab_price', 'bundle_price_sqft',
                'special_price_per_sqft', 'owner_approval_price', 'loose_slab_per_slab', 'bundle_price_per_slab',
                'special_price_per_slab', 'owner_approval_price_per_slab', 'price12', 'price_range_id'
                ),
            ];

            $data['serviceData']['is_taxable_item']         = $request->has('is_taxable_item') ? 1 : 0;
            $data['serviceData']['frequent_in_so']          = $request->has('frequent_in_so') ? 1 : 0;
            $data['serviceData']['frequent_in_customer_cm'] = $request->has('frequent_in_customer_cm') ? 1 : 0;
            $data['serviceData']['frequent_in_po']          = $request->has('frequent_in_po') ? 1 : 0;
            $data['serviceData']['frequent_in_supplier_cm'] = $request->has('frequent_in_supplier_cm') ? 1 : 0;

            $this->serviceRepository->update($data, $service->id);

            return response()->json(['status' => 'success', 'msg' => 'Service updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating service: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the service.']);
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
            $service = $this->serviceRepository->findOrFail($id);
            if ($service) {
                if ($service->status == 0) {
                    return response()->json(['status' => 'false', 'msg' => 'Service is already inactive.']);
                }
                // Mark service as inactive
                $service->status = 0;
                $service->save();

                return response()->json(['status' => 'success', 'msg' => 'Service marked as inactive.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Service not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating service status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the service status.']);
        }
    }

    public function getServiceDataTableList(Request $request)
    {
        return $this->serviceRepository->dataTable($request);
    }

    public function serviceChangeStatus($id)
    {
        try {
            $service = $this->serviceRepository->findOrFail($id);
            $newStatus       = $service->status == 1 ? 0 : 1;
            $service->status = $newStatus;
            $service->save();

            return response()->json([
                'status'     => 'success',
                'new_status' => $newStatus,
                'msg'        => 'Status updated successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'msg'    => 'Failed to update status.',
            ], 500);
        }
    }

    public function serviceUploadImage(Request $request)
    {
        if ($request->hasFile('service_image')) {
            $this->serviceRepository->updateImage($request->only('service_image'), $request->id);
            return response()->json(['status' => 'success', 'msg' => 'Image uploaded successfully']);
        }
        return response()->json(['status' => 'false', 'msg' => 'Image upload failed.'], 400);
    }
}
