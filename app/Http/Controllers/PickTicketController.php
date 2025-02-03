<?php

namespace App\Http\Controllers;

// use App\Models\User;
use App\Models\County;
use App\Models\Company;
use App\Models\Service;
use App\Models\Account;
use App\Models\Customer;
use App\Models\SaleOrder;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Models\AccountPaymentTerm;
use App\Repositories\SaleOrder\PickTicketRepository;
// use App\Models\Country;
// use App\Models\TaxCode;
// use App\Models\FileType;
// use App\Models\EventType;
// use App\Models\Associate;
// use App\Models\Opportunity;
// use App\Models\ProjectType;

// use App\Models\CustomerType;
// use App\Models\AboutUsOption;
// use App\Models\EndUseSegment;
// use App\Models\PriceListLabel;
// use App\Models\OpportunityStage;
// use App\Models\SaleOrderContact;

// use App\Models\ProbabilityToClose;
// use App\Models\printDocDisclaimer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PickTicketController extends Controller
{
    private PickTicketRepository $pickTicketRepository;
    public function __construct(PickTicketRepository $pickTicketRepository)
    {
        $this->pickTicketRepository = $pickTicketRepository;
    }

    public function getDropDownData()
    {
        $expenditures       = Expenditure::query()->select('expenditure_name', 'expenditure_code', 'id')->where('is_frieght_expenditure', 1)->get();
        $counties           = County::query()->pluck('county_name', 'id');
        $companies          = Company::query()->select('id', 'company_name')->get();
        $paymentTerms       = AccountPaymentTerm::query()->select('id', 'payment_label')->where('payment_not_used_sales', 1)->get();
        $services           = Service::query()->pluck('service_name', 'id');
        $accounts           = Account::query()->select('account_name', 'account_number', 'id')->get();
        // $users              = User::query()->select(DB::raw("CONCAT(first_name, ' - ', last_name) as name"), 'id')->pluck('name', 'id');
        // $customerTypes      = CustomerType::query()->select('id', 'customer_type_name')->get();
        // $customers          = Customer::query()->select('id', 'customer_name', 'customer_code', 'mobile', 'address')->get();
        // $customerCount      = Customer::query()->count();
        // $associates         = Associate::query()->select('id', 'associate_name')->get();
        // $countries          = Country::query()->pluck('country_name', 'id');
        // $priceListLabels    = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        // $salesTaxs          = TaxCode::query()->select(DB::raw("CONCAT(tax_code, ' - ', tax_code_label) as tax_name"), 'id')->pluck('tax_name', 'id');
        // $aboutUsOptions     = AboutUsOption::query()->pluck('how_did_you_hear_option', 'id');
        // $probabilityCloses  = ProbabilityToClose::query()->pluck('probability_to_close', 'id');
        // $eventTypes         = EventType::query()->pluck('event_type_name', 'id');
        // $printDocDisclaimer = PrintDocDisclaimer::query()->pluck('title', 'id');
        //
        // return compact('companies', 'paymentTerms', 'users', 'priceListLabels', 'customerTypes', 'customers', 'customerCount', 'associates', 'countries', 'counties', 'salesTaxs', 'aboutUsOptions', 'probabilityCloses', 'eventTypes', 'expenditures', 'printDocDisclaimer', 'services');
        return compact('expenditures', 'counties', 'paymentTerms', 'services', 'accounts');
    }

    public function create(Request $request)
    {
        $id = $request->query('id');
        $sale_order = SaleOrder::findOrFail($id);
        $customer = Customer::find($sale_order->billing_customer_id);
        $company = $sale_order ? Company::find($sale_order->location_id) : null;
        $payment_term = $customer ? AccountPaymentTerm::find($customer->payment_terms_id) : null;
        // $user = User::find($sale_order->entered_by_id);
        // $primary_sales = $sale_order->primary_sales_person_id ? User::find($sale_order->primary_sales_person_id) : null;
        // $secondary_sales = $sale_order->secondary_sales_person_id ? User::find($sale_order->secondary_sales_person_id) : null;
        // $user = $sale_order ? User::find($sale_order->entered_by_id) : null;
        // $taxcode = $sale_order->sales_tax_id ? TaxCode::find($sale_order->sales_tax_id) : null;
        // $price_list = PriceListLabel::find($sale_order->price_level_label_id);
        // $date = $sale_order->sales_order_date ? \Carbon\Carbon::parse($sale_order->sales_order_date)->format('M d, Y') : null;
        // $sales_order_date = $sale_order->updated_at ? \Carbon\Carbon::parse($sale_order->updated_at)->format('M d Y g:iA') : null;
        // $fabricator = Associate::find($sale_order->fabricator_id);
        // $designer = Associate::find($sale_order->designer_id);
        // $reffered_by = Associate::find($sale_order->builder_id);
        // $freight_carrier = Expenditure::find($sale_order->freight_carrier_id);
        // $route = County::find($sale_order->route_id);
        // $how_did_hear = $opportunity->how_did_hear_about_us_id ? AboutUsOption::find($opportunity->how_did_hear_about_us_id) : null;
        // $sale_order_contacts = OpportunityContact::where('opportunity_id', $id)
        //     ->with('contact')
        //     ->get();
        // $sale_order_contacts = SaleOrderContact::where('sales_order_id', $id)
        //     ->with('contact')
        //     ->get();
        // $contacts = $sale_order_contacts->map(function ($sale_order_contact) {
        //     return [
        //         'name' => optional($sale_order_contact->contact)->contact_name ?? 'Unknown Contact',
        //         'sale_order_contact_id' => $sale_order_contact->id,
        //     ];
        // });

        // $fileTypes = FileType::where('file_type_saleorder', 1)->select('id', 'file_Type')->get();
        $data = $this->getDropDownData();
        // return view('sale_order.pick_ticket.__create', compact('sale_order', 'customer', 'company', 'date', 'sales_order_date', 'user', 'primary_sales', 'secondary_sales', 'taxcode', 'price_list', 'payment_term', 'reffered_by', 'fabricator', 'designer', 'freight_carrier', 'route', 'contacts', 'fileTypes', 'data'));
        return view('sale_order.pick_ticket.__create', compact('sale_order', 'customer', 'company', 'payment_term', 'data'));

    }
    public function getPickTicketDataTableList(Request $request, $id)
    {
        return $this->pickTicketRepository->dataTable($request, $id);
    }
}
