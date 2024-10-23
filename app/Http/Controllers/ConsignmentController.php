<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use App\Models\Consignment;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Models\PriceListLabel;
use App\Models\AccountPaymentTerm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\ConsignmentRepository;

class ConsignmentController extends Controller
{
    public $consignmentRepository;

    public function __construct(ConsignmentRepository $consignmentRepository)
    {
        $this->consignmentRepository = $consignmentRepository;
    }

    public function index()
    {
        $customerTypes       = CustomerType::query()->pluck('customer_type_name', 'id');
        $companies           = Company::query()->pluck('company_name', 'id');
        $users               = User::query()->select(DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'id')->get()->pluck('name', 'id');
        $priceListLabels     = PriceListLabel::query()->select(DB::raw("CONCAT(price_code, ' - ', price_label) as label"), 'id')->pluck('label', 'id');
        $accountPaymentTerms = AccountPaymentTerm::query()->pluck('payment_label', 'id');
        $salesTaxs           = DB::table('tax_codes')->join('tax_code_components', 'tax_codes.id', '=', 'tax_code_components.tax_code_id')
            ->select('tax_codes.id', DB::raw("CONCAT(tax_codes.tax_code, ' - ', tax_codes.tax_code_label, ' - ', SUM(tax_code_components.rate), ' %') as name"))
            ->groupBy('tax_codes.id')
            ->get()->pluck('name', 'id');
        return view('consignment.consignments', compact('customerTypes', 'companies', 'users', 'priceListLabels', 'accountPaymentTerms', 'salesTaxs'));
    }

    public function store(Request $request)
    {
        try {
            $this->consignmentRepository->store($request->only('consignment_date', 'consignment_location_id', 'consignment_type'));
            return response()->json(['status' => 'success', 'msg' => 'Consignment saved successfully.'], 200);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Consignment: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while saving the Consignment.'], 500);
        }
    }

    public function create()
    {
        return view('consignment.__create');
    }

    public function destroy($id)
    {
        try {
            $consignment = $this->consignmentRepository->findOrFail($id);
            if ($consignment) {
                $this->consignmentRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Consignment deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Consignment not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Consignment: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Consignment.']);
        }
    }

    public function getConsignmentDataTableList(Request $request, $status)
    {
        return $this->consignmentRepository->dataTable($request, $status);
    }
    public function getCustomerListDataTableList(Request $request)
    {
        return $this->consignmentRepository->dataTableCustomerList($request);
    }
    public function getCreateCustomerListDataTableList(Request $request, $status)
    {
        return $this->consignmentRepository->dataTableCreateCustomerList($request, $status);
    }
}
