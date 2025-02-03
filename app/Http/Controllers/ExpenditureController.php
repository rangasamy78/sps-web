<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\County;
use App\Models\Account;
use App\Models\Company;
use App\Models\Country;
use App\Models\VendorType;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Models\LinkedAccount;
use App\Models\PaymentMethod;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\ExpenditureRepository;
use App\Http\Requests\Expenditure\CreateExpenditureRequest;
use App\Http\Requests\Expenditure\UpdateExpenditureRequest;

class ExpenditureController extends Controller
{
    private ExpenditureRepository $expenditureRepository;

    public function __construct(ExpenditureRepository $expenditureRepository)
    {
        $this->expenditureRepository = $expenditureRepository;
    }

    public function index()
    {
        return view('expenditure.expenditures');
    }

    public function create()
    {
        $vendor_types                = VendorType::query()->pluck('vendor_type_name', 'id');
        $company                     = Company::query()->pluck('company_name', 'id');
        $country                     = Country::query()->pluck('country_name', 'id');
        $payment_methods             = PaymentMethod::query()->pluck('payment_method_name', 'id');
        $linked_accounts = Account::query()->get();
        $account_payment_terms       = AccountPaymentTerm::query()->pluck('payment_label', 'id');
        return view('expenditure.create', compact('vendor_types','company','country','payment_methods','linked_accounts','account_payment_terms'));
    }

    public function store(CreateExpenditureRequest $request)
    {
        try {
            $this->expenditureRepository->store($request->only('expenditure_name','print_name','expenditure_code','expenditure_type_id','parent_location_id','contact_name', 'since_date', 'primary_phone', 'secondary_phone', 'mobile', 'fax', 'email', 'website', 'address', 'suite', 'city', 'state', 'zip', 'country_id', 'shipping_address', 'shipping_suite', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country_id', 'payment_terms', 'currency', 'expense_account_id', 'payment_method_id', 'account', 'tax', 'memo', 'ein', 'is_generic_expenditure', 'is_print_1099', 'is_frieght_expenditure', 'is_sub_contractor', 'is_allow_login', 'expenditure_username', 'expenditure_password', 'internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Expenditure saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error Saving Expenditure: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Expenditure.']);
        }
    }

    public function show($id)
    {
        $expenditure                 = Expenditure::findOrFail($id);
        $vendor_types                = VendorType::query()->join('expenditures', 'vendor_types.id', '=', 'expenditures.expenditure_type_id')->where('expenditures.id', $id)->first();
        $company                     = Company::query()->pluck('company_name', 'id');
        $country                     = Country::query()->pluck('country_name', 'id');
        $counties                     = County::query()->pluck('county_name', 'id');
        $payment_methods             = PaymentMethod::query()->pluck('payment_method_name', 'id');
        $linked_accounts             = LinkedAccount::query()->join('expenditures', 'linked_accounts.id', '=', 'expenditures.expense_account_id')->where('expenditures.id', $id)->first();
        $account_payment_terms       = AccountPaymentTerm::query()->join('expenditures', 'account_payment_terms.id', '=', 'expenditures.payment_terms')->where('account_payment_terms.id', $id)->first();
        return view('expenditure.__show', compact('expenditure', 'vendor_types','company','country','payment_methods','linked_accounts','account_payment_terms','counties'));
    }

    public function edit($id)
    {
        $expenditure                 = Expenditure::findOrFail($id);
        $vendor_types                = VendorType::query()->pluck('vendor_type_name', 'id');
        $company                     = Company::query()->pluck('company_name', 'id');
        $country                     = Country::query()->pluck('country_name', 'id');
        $payment_methods             = PaymentMethod::query()->pluck('payment_method_name', 'id');
        $linked_accounts = Account::query()->get();
        $account_payment_terms       = AccountPaymentTerm::query()->pluck('payment_label', 'id');
        return view('expenditure.edit', compact('expenditure','vendor_types','company','country','payment_methods','linked_accounts','account_payment_terms'));
    }

    public function update(UpdateExpenditureRequest $request, Expenditure $expenditure)
    {
        try {
            $this->expenditureRepository->update($request->only('expenditure_name','print_name','expenditure_code','expenditure_type_id','parent_location_id','contact_name', 'since_date', 'primary_phone', 'secondary_phone', 'mobile', 'fax', 'email', 'website', 'address', 'suite', 'city', 'state', 'zip', 'country_id', 'shipping_address', 'shipping_suite', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country_id', 'payment_terms', 'currency', 'expense_account_id', 'payment_method_id', 'account', 'tax', 'memo', 'ein', 'is_generic_expenditure', 'is_print_1099', 'is_frieght_expenditure', 'is_sub_contractor', 'is_allow_login', 'expenditure_username', 'expenditure_password', 'internal_notes'), $expenditure->id);
            return response()->json(['status' => 'success', 'msg' => 'Expenditure updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Expenditure: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Expenditure.']);
        }
    }

    public function destroy($id)
    {
        try {
            $expenditure = $this->expenditureRepository->findOrFail($id);
            if ($expenditure) {
                if ($expenditure->status == 0) {
                    return response()->json(['status' => 'false', 'msg' => 'Expenditure is already inactive.']);
                }
                $expenditure->status = 0;
                $expenditure->save();

                return response()->json(['status' => 'success', 'msg' => 'Expenditure marked as inactive.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Expenditure not found.']);
            }
        } catch (Exception $e) {

            Log::error('Error updating Expenditure status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Expenditure status.']);
        }
    }

    public function getExpenditureDataTableList(Request $request)
    {
        return $this->expenditureRepository->dataTable($request);
    }

    public function expenditureChangeStatus($id)
    {
        try {
            $expenditure = $this->expenditureRepository->findOrFail($id);

            $newStatus         = $expenditure->status == 1 ? 0 : 1;
            $expenditure->status = $newStatus;
            $expenditure->save();

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
}
