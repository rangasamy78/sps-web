<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\County;
use App\Models\Company;
use App\Models\Country;
use App\Models\TaxCode;
use App\Models\Service;
use App\Models\Customer;
use App\Models\FileType;
use App\Models\SaleOrder;
use App\Models\EventType;
use App\Models\Associate;
use App\Models\Opportunity;
use App\Models\Consignment;
use App\Models\ProjectType;
use App\Models\ProductType;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Models\CustomerType;
use App\Models\ProductGroup;
use App\Models\AboutUsOption;
use App\Models\EndUseSegment;
use App\Models\PriceListLabel;
use App\Models\ProductCategory;
use App\Models\OpportunityStage;
use App\Models\SaleOrderContact;
use App\Models\AccountPaymentTerm;
use App\Models\ProbabilityToClose;
use App\Models\printDocDisclaimer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SaleOrderRepository;
use App\Http\Requests\SaleOrder\{CreateSaleOrderRequest, UpdateSaleOrderRequest};

class SaleOrderController extends Controller
{
    private SaleOrderRepository $saleOrderRepository;

    public function __construct(SaleOrderRepository $saleOrderRepository)
    {
        $this->saleOrderRepository = $saleOrderRepository;
    }
    public function index()
    {
        $data = $this->getDropDownData();
        return view('sale_order.sale_orders', compact('data'));
    }

    public function create()
    {
        $data = $this->getDropDownData();
        $lastSo = DB::table('sale_orders')
            ->orderBy('id', 'desc')
            ->value('sales_order_code');
        $newSo = $lastSo
            ? str_pad(((int)$lastSo + 1) % 10000, 4, '0', STR_PAD_LEFT)
            : '0001';
        return view('sale_order.create.__create', compact('data', 'newSo'));
    }

    public function getDropDownData()
    {
        $companies          = Company::query()->select('id', 'company_name')->get();
        $paymentTerms       = AccountPaymentTerm::query()->select('id', 'payment_label')->where('payment_not_used_sales', 1)->get();
        $users              = User::query()->select(DB::raw("CONCAT(first_name, ' - ', last_name) as name"), 'id')->pluck('name', 'id');
        $customerTypes      = CustomerType::query()->select('id', 'customer_type_name')->get();
        $customers          = Customer::query()->select('id', 'customer_name', 'customer_code', 'mobile', 'address')->get();
        $customerCount      = Customer::query()->count();
        $associates         = Associate::query()->select('id', 'associate_name')->get();
        $counties           = County::query()->pluck('county_name', 'id');
        $countries          = Country::query()->pluck('country_name', 'id');
        $priceListLabels    = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        $salesTaxs          = TaxCode::query()->select(DB::raw("CONCAT(tax_code, ' - ', tax_code_label) as tax_name"), 'id')->pluck('tax_name', 'id');
        $aboutUsOptions     = AboutUsOption::query()->pluck('how_did_you_hear_option', 'id');
        $probabilityCloses  = ProbabilityToClose::query()->pluck('probability_to_close', 'id');
        $eventTypes         = EventType::query()->pluck('event_type_name', 'id');
        $expenditures       = Expenditure::query()->select('expenditure_name', 'expenditure_code', 'id')->where('is_frieght_expenditure', 1)->get();
        $printDocDisclaimer = PrintDocDisclaimer::query()->pluck('title', 'id');
        $services           = Service::query()->pluck('service_name', 'id');
        $productTypes       = ProductType::query()->pluck('product_type', 'id');
        $productCategories  = ProductCategory::query()->pluck('product_category_name', 'id');
        $productGroups      = ProductGroup::query()->pluck('product_group_name', 'id');
        $locations          = Consignment::with('customer')->get()->pluck('customer.customer_name');
        return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'aboutUsOptions', 'probabilityCloses', 'eventTypes', 'expenditures', 'printDocDisclaimer', 'services', 'productTypes', 'productCategories', 'productGroups', 'locations');
    }

    public function getRecord($step)
    {
        $record = PrintDocDisclaimer::where('id', $step)->first();

        if ($record) {
            return response()->json(['data' => $record->policy]);
        } else {
            return response()->json(['data' => 'No record found for this step']);
        }
    }

    public function store(CreateSaleOrderRequest $request)
    {
        try {
            $this->saleOrderRepository->store($request->only('sales_order_code', 'sales_order_date', 'customer_po_code', 'location_id', 'billing_customer_id', 'attn', 'payment_term_id', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'is_cod', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'requested_ship_date', 'est_delivery_date', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'commission_amount', 'commission_notes', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'freight_carrier_id', 'route_id', 'shipping_tracking_number', 'print_doc_disclaimer_id', 'print_doc_description_editor', 'entered_by_id'));
            return response()->json(['status' => 'success', 'msg' => 'sales order saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving sales order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the sales order option.']);
        }
    }

    public function show($id)
    {
        $sale_order = SaleOrder::findOrFail($id);
        $customer = Customer::find($sale_order->billing_customer_id);
        $company = $sale_order ? Company::find($sale_order->location_id) : null;
        $primary_sales = $sale_order->primary_sales_person_id ? User::find($sale_order->primary_sales_person_id) : null;
        $secondary_sales = $sale_order->secondary_sales_person_id ? User::find($sale_order->secondary_sales_person_id) : null;
        $user = $sale_order ? User::find($sale_order->entered_by_id) : null;
        $taxcode = $sale_order->sales_tax_id ? TaxCode::find($sale_order->sales_tax_id) : null;
        $price_list = PriceListLabel::find($sale_order->price_level_label_id);
        $payment_term = $customer ? AccountPaymentTerm::find($customer->payment_terms_id) : null;
        $date = $sale_order->sales_order_date ? \Carbon\Carbon::parse($sale_order->sales_order_date)->format('M d, Y') : null;
        $sales_order_date = $sale_order->updated_at ? \Carbon\Carbon::parse($sale_order->updated_at)->format('M d Y g:iA') : null;
        $fabricator = Associate::find($sale_order->fabricator_id);
        $designer = Associate::find($sale_order->designer_id);
        $reffered_by = Associate::find($sale_order->builder_id);
        $freight_carrier = Expenditure::find($sale_order->freight_carrier_id);
        $route = County::find($sale_order->route_id);
        $sale_order_contacts = SaleOrderContact::where('sales_order_id', $id)
            ->with('contact')
            ->get();
        $contacts = $sale_order_contacts->map(function ($sale_order_contact) {
            return [
                'name' => optional($sale_order_contact->contact)->contact_name ?? 'Unknown Contact',
                'sale_order_contact_id' => $sale_order_contact->id,
            ];
        });

        $fileTypes = FileType::where('file_type_saleorder', 1)->select('id', 'file_Type')->get();
        $data = $this->getDropDownData();
        return view('sale_order.show.__show', compact('sale_order', 'customer', 'company', 'date', 'sales_order_date', 'user', 'primary_sales', 'secondary_sales', 'taxcode', 'price_list', 'payment_term', 'reffered_by', 'fabricator', 'designer', 'freight_carrier', 'route', 'contacts', 'fileTypes', 'data'));
    }

    public function edit($id)
    {
        $data = $this->getDropDownData();
        $sale_order = $this->saleOrderRepository->findOrFail($id);
        $billCustomer = Customer::find($sale_order->billing_customer_id);
        $fabricator = Associate::find($sale_order->fabricator_id) ?? new Associate(['associate_name' => '']);
        $designer = Associate::find($sale_order->designer_id) ?? new Associate(['associate_name' => '']);
        $builder = Associate::find($sale_order->builder_id) ?? new Associate(['associate_name' => '']);
        return view('sale_order.edit.__edit', compact(
            'sale_order',
            'billCustomer',
            'fabricator',
            'designer',
            'builder',
            'data'
        ));
    }

    public function update(UpdateSaleOrderRequest $request, SaleOrder $saleOrder)
    {
        try {
            $this->saleOrderRepository->update($request->only('sales_order_code', 'sales_order_date', 'customer_po_code', 'location_id', 'billing_customer_id', 'attn', 'payment_term_id', 'price_level_label_id', 'primary_sales_person_id', 'secondary_sales_person_id', 'is_cod', 'sales_tax_id', 'ship_to_type', 'ship_to_job_name', 'ship_to_attn', 'ship_to_id', 'ship_to_name', 'ship_to_address', 'ship_to_suite', 'ship_to_city', 'ship_to_state', 'ship_to_zip', 'ship_to_county_id', 'ship_to_country_id', 'ship_to_phone', 'ship_to_fax', 'ship_to_mobile', 'ship_to_lot', 'ship_to_sub_division', 'ship_to_email', 'requested_ship_date', 'est_delivery_date', 'ship_to_is_do_not_send_email', 'fabricator_id', 'designer_id', 'builder_id', 'commission_amount', 'commission_notes', 'special_instructions', 'internal_notes', 'printed_notes', 'survey_rating_notes', 'freight_carrier_id', 'route_id', 'shipping_tracking_number', 'print_doc_disclaimer_id', 'print_doc_description_editor', 'entered_by_id'), $saleOrder->id);
            return response()->json(['status' => 'success', 'msg' => 'sales order updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating sales order: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the sales order option.']);
        }
    }

    public function updateInternalNotes(Request $request, $id)
    {
        try {
            $sale_order = SaleOrder::findOrFail($id);
            $existingNotes = $sale_order->internal_notes ?? '';
            $newNotes = $request->input('internal_notes');
            $sale_order->internal_notes = $existingNotes . "\n" . $newNotes;
            $sale_order->save();
            return response()->json([
                'status' => 'success',
                'msg' => 'Internal notes updated successfully.',
                'data' => $sale_order->internal_notes
            ]);
        } catch (Exception $e) {
            Log::error('Error updating internal notes: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating internal notes.']);
        }
    }

    public function destroy(SaleOrder $saleOrder)
    {

    }
    public function getSaleOrderDataTableList(Request $request)
    {
        return $this->saleOrderRepository->dataTable($request);
    }
    public function getAllCustomerDataTableList(Request $request)
    {
        return $this->saleOrderRepository->dataTableAllCustomer($request);
    }
    public function getAllAssociateDataTableList(Request $request)
    {
        return $this->saleOrderRepository->dataTableAllAssociate($request);
    }
    public function getAllShipToDataTableList(Request $request, $id)
    {
        return $this->saleOrderRepository->dataTableAllShipTo($request, $id);
    }
    public function searchProduct(Request $request)
    {
        return $this->saleOrderRepository->searchProductDataTable($request);
    }
}
