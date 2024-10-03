<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxCode\CreateTaxCodeRequest;

use Exception;
use App\Models\Account;
use App\Models\TaxCode;
use App\Models\TaxComponent;
use Illuminate\Http\Request;
use App\Models\TaxCodeComponent;
use App\Repositories\TaxCodeRepository;
use App\Services\TaxCode\TaxCodeService;
use App\Http\Requests\TaxCode\UpdateTaxCodeRequest;
use Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\Log;

class TaxCodeController extends Controller
{
    public TaxCodeRepository $taxCodeRepository;
    public TaxCodeService $taxCodeService;

    public function __construct(TaxCodeRepository $taxCodeRepository, TaxCodeService $taxCodeService)
    {
        $this->taxCodeService    = $taxCodeService;
        $this->taxCodeRepository = $taxCodeRepository;
    }

    public function index()
    {
        $data = $this->__getDropDownData();
        return view('tax_code.tax_codes', compact('data'));
    }

    public function create()
    {
        $data          = $this->__getDropDownData();
        $nextSortOrder = $this->taxCodeService->getNextSortOrder();
        return view('tax_code.create', compact('data', 'nextSortOrder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaxCodeRequest $request)
    {
        try {
            $this->taxCodeRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Tax Code saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving tax code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the tax code.']);
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
        $tax_code = $this->taxCodeRepository->findOrFail($id);
        return view('tax_code.show', compact('tax_code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax_code            = $this->taxCodeRepository->findOrFail($id);
        $tax_code_components = TaxCodeComponent::query()->where('tax_code_id', $id)->get();
        $tax_component       = TaxComponent::query()->where('tax_code_id', $id)->first();
        $data                = $this->__getDropDownData();
        return view('tax_code.edit', compact('data', 'tax_code', 'tax_component', 'tax_code_components'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxCodeRequest $request, TaxCode $taxCode)
    {
        try {
            $this->taxCodeRepository->update($request->all(), $taxCode->id);
            return response()->json(['status' => 'success', 'msg' => 'Tax Code updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating tax code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating tax code.']);
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
            $taxCode = $this->taxCodeRepository->findOrFail($id);
            if ($taxCode) {
                $this->taxCodeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Tax Code deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Tax Code not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting tax code: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting tax code.']);
        }
    }

    public function getTaxCodeDataTableList(Request $request)
    {
        return $this->taxCodeRepository->dataTable($request);
    }

    private function __getDropDownData($customer = null)
    {
        $tax_components = TaxComponent::query()->pluck('component_name', 'id');
        $sales_taxes    = Account::query()->select(DB::raw("CONCAT(account_number, ' - ', account_name) AS account_details"), 'id')->where('special_account_type_id', 4)->pluck('account_details', 'id');
        return compact('tax_components', 'sales_taxes');
    }

    public function getGLAccountNumber($taxComponentId)
    {
        $account = DB::table('tax_components')
            ->join('accounts', 'accounts.id', '=', 'tax_components.sales_tax_id')
            ->select('tax_components.id',
                DB::raw("CONCAT(accounts.account_number, ' - ', accounts.account_name) AS account_details"))
            ->where('tax_components.id', '=', $taxComponentId)
            ->first();

        if ($account) {
            return response()->json(['account_number' => $account->account_details]);
        } else {
            return response()->json(['error' => 'Account not found'], 404);
        }
    }
}
