<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxComponent\CreateTaxComponentRequest;

use App\Http\Requests\TaxComponent\UpdateTaxComponentRequest;
use App\Models\Account;
use App\Models\TaxAuthority;
use App\Models\TaxComponent;
use App\Repositories\TaxComponentRepository;
use App\Services\TaxComponent\TaxComponentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\Log;

class TaxComponentController extends Controller
{
    public $taxComponentService;
    public $taxComponentRepository;

    public function __construct(TaxComponentRepository $taxComponentRepository, TaxComponentService $taxComponentService)
    {
        $this->taxComponentService    = $taxComponentService;
        $this->taxComponentRepository = $taxComponentRepository;
    }

    public function index()
    {
        $tax_authorities = TaxAuthority::query()->pluck('authority_name', 'id');
        return view('tax_component.tax_components', compact('tax_authorities'));
    }

    public function create()
    {
        $data = $this->__getDropDownData();
        $nextSortOrder   = $this->taxComponentService->getNextSortOrder();
        return view('tax_component.create', compact('data', 'nextSortOrder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaxComponentRequest $request)
    {
        try {
            $this->taxComponentRepository->store($request->only('sort_order', 'component_name', 'component_tax_id', 'authority_id', 'sales_tax_id'));
            return response()->json(['status' => 'success', 'msg' => 'Tax Component saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Tax Component: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Tax Component.']);
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
        $tax_component = $this->taxComponentRepository->findOrFail($id);
        return view('tax_component.show', compact('tax_component'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax_component   = $this->taxComponentRepository->findOrFail($id);
        $data = $this->__getDropDownData();
        return view('tax_component.edit', compact('data', 'tax_component'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxComponentRequest $request, TaxComponent $taxComponent)
    {
        try {
            $this->taxComponentRepository->update($request->only('sort_order', 'component_name', 'component_tax_id', 'authority_id', 'sales_tax_id'), $taxComponent->id);
            return response()->json(['status' => 'success', 'msg' => 'Tax Component updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Tax Component: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating Tax Component.']);
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
            $taxComponent = $this->taxComponentRepository->findOrFail($id);
            if ($taxComponent) {
                $this->taxComponentRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Tax Component deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Tax Component not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Tax Component: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting Tax Component.']);
        }
    }

    public function getTaxComponentDataTableList(Request $request)
    {
        return $this->taxComponentRepository->dataTable($request);
    }

    private function __getDropDownData($customer = null)
    {
        $tax_authorities  = TaxAuthority::query()->pluck('authority_name', 'id');
        $sales_taxes      = Account::query()->select(DB::raw("CONCAT(account_number, ' - ', account_name) AS account_details"), 'id')->where('special_account_type_id', 4)->pluck('account_details', 'id');
        return compact('tax_authorities', 'sales_taxes');
    }
}
