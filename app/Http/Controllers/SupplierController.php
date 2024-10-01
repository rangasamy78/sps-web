<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\County;
use App\Models\Company;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Supplier;
use App\Models\Language;
use App\Models\SupplierType;
use App\Models\SupplierPort;
use Illuminate\Http\Request;
use App\Models\ShipmentTerm;
use App\Models\PaymentMethod;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\{SupplierRepository, DropDownRepository};
use App\Http\Requests\Supplier\{CreateSupplierRequest, UpdateSupplierRequest};

class SupplierController extends Controller
{
    private SupplierRepository $supplierRepository;
    public DropDownRepository $dropDownRepository;

    public function __construct(SupplierRepository $supplierRepository, DropDownRepository $dropDownRepository)
    {
        $this->supplierRepository = $supplierRepository;
        $this->dropDownRepository = $dropDownRepository;
    }
    public function index()
    {
        $totalSupplier = Supplier::count();
        $totalParentSupplier = Supplier::whereNotNull('parent_supplier_id')->count();
        $totalDiscountSupplier = Supplier::whereNotNull('discount')->count();
        $totalMultiLocationSupplier = Supplier::whereNotNull('multi_location_supplier')->where('multi_location_supplier', '!=', 0)->count();
        $languages = Language::query()->select('id', 'language_name')->get();
        $supplierTypes = SupplierType::query()->select('id', 'supplier_type_name')->get();
        $currencies = Currency::query()->select('id', 'currency_name', 'currency_code')->get();
        $companies = Company::query()->select('id', 'company_name')->get();
        $paymentTerms = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        return view('supplier.suppliers', compact('totalSupplier', 'totalParentSupplier', 'totalDiscountSupplier', 'totalMultiLocationSupplier', 'languages', 'supplierTypes', 'currencies', 'companies', 'paymentTerms'));
    }

    public function create()
    {
        $allSuppliers = Supplier::query()->select('id', 'supplier_name')->get();
        $supplierTypes = SupplierType::query()->select('id', 'supplier_type_name')->get();
        $supplierPorts = SupplierPort::query()->select('id', 'supplier_port_name')->get();
        $languages = Language::query()->select('id', 'language_name')->get();
        $companies = Company::query()->select('id', 'company_name')->get();
        $currencies = Currency::query()->select('id', 'currency_name', 'currency_code')->get();
        $paymentTerms = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $shipmentTerms = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $paymentMethods = PaymentMethod::query()->select('id', 'payment_method_name')->get();
        $countries = Country::query()->select('id', 'country_name')->get();
        return view('supplier.__create', compact('allSuppliers', 'supplierTypes', 'supplierPorts', 'languages', 'companies', 'currencies', 'paymentTerms', 'shipmentTerms', 'paymentMethods', 'countries'));
    }

    public function store(CreateSupplierRequest $request)
    {
        try {
            $this->supplierRepository->store($request->only('supplier_name', 'print_name', 'code', 'contact_name', 'supplier_type_id', 'parent_location_id', 'multi_location_supplier', 'language_id', 'parent_supplier_id', 'supplier_since', 'supplier_port_id', 'markup_multiplier', 'discount', 'primary_phone', 'secondary_phone', 'mobile', 'fax', 'email', 'website', 'remit_address', 'remit_suite', 'remit_city', 'remit_state', 'remit_zip', 'remit_country_id', 'ship_address', 'ship_suite', 'ship_city', 'ship_state', 'ship_zip', 'ship_country_id', 'credit_limit', 'ein_number', 'account', 'currency_id', 'payment_terms_id', 'shipment_terms_id', 'purchase_tax_id', 'frieght_forwarder_id', 'default_payment_method_id', 'shipping_instruction', 'internal_notes', 'allow_access_to_supplier', 'supplier_username', 'supplier_password', 'form_1099_printed', 'status'));
            return response()->json(['status' => 'success', 'msg' => 'Supplier saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Supplier : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Supplier.']);
        }
    }

    public function show($id)
    {
        $countyies = County::query()->select('id', 'county_name')->get();
        $countries = Country::query()->select('id', 'country_name')->get();
        $supplier = $this->supplierRepository->findOrFail($id);
        $supplier->supplier_since = Carbon::parse($supplier->supplier_since)->format('F j, Y');
        return view('supplier.__show', compact('supplier', 'countyies', 'countries'));
    }

    public function edit($id)
    {
        $allSuppliers = Supplier::query()->select('id', 'supplier_name')->get();
        $supplierTypes = SupplierType::query()->select('id', 'supplier_type_name')->get();
        $supplierPorts = SupplierPort::query()->select('id', 'supplier_port_name')->get();
        $languages = Language::query()->select('id', 'language_name')->get();
        $companies = Company::query()->select('id', 'company_name')->get();
        $currencies = Currency::query()->select('id', 'currency_name', 'currency_code')->get();
        $paymentTerms = AccountPaymentTerm::query()->select('id', 'payment_label')->get();
        $shipmentTerms = ShipmentTerm::query()->select('id', 'shipment_term_name')->get();
        $paymentMethods = PaymentMethod::query()->select('id', 'payment_method_name')->get();
        $countries = Country::query()->select('id', 'country_name')->get();
        $supplier = $this->supplierRepository->findOrFail($id);
        return view('supplier.__edit', compact('supplier', 'allSuppliers', 'supplierTypes', 'supplierPorts', 'languages', 'companies', 'currencies', 'paymentTerms', 'shipmentTerms', 'paymentMethods', 'countries'));
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        try {
            $this->supplierRepository->update($request->only('supplier_name', 'print_name', 'code', 'contact_name', 'supplier_type_id', 'parent_location_id', 'multi_location_supplier', 'language_id', 'parent_supplier_id', 'supplier_since', 'supplier_port_id', 'markup_multiplier', 'discount', 'primary_phone', 'secondary_phone', 'mobile', 'fax', 'email', 'website', 'remit_address', 'remit_suite', 'remit_city', 'remit_state', 'remit_zip', 'remit_country_id', 'ship_address', 'ship_suite', 'ship_city', 'ship_state', 'ship_zip', 'ship_country_id', 'credit_limit', 'ein_number', 'account', 'currency_id', 'payment_terms_id', 'shipment_terms_id', 'purchase_tax_id', 'frieght_forwarder_id', 'default_payment_method_id', 'shipping_instruction', 'internal_notes', 'allow_access_to_supplier', 'supplier_username', 'supplier_password', 'form_1099_printed', 'status'), $supplier->id);
            return response()->json(['status' => 'success', 'msg' => 'Supplier updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Supplier: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Supplier.']);
        }
    }

    public function updateStatus($id)
    {
        try {
            $supplier = $this->supplierRepository->findOrFail($id);
            $supplier->status = $supplier->status === 1 ? 0 : 1;
            $supplier->save();
            return response()->json(['status' => 'success', 'msg' => 'Supplier Status updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating  status of Supplier: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Status of Supplier.']);
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = $this->supplierRepository->findOrFail($id);
            if ($supplier) {
                $this->supplierRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Supplier deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Supplier not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Supplier: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Supplier.']);
        }
    }

    public function getSupplierDataTableList(Request $request)
    {
        return $this->supplierRepository->dataTable($request);
    }
}
