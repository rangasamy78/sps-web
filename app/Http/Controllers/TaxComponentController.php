<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\TaxComponent;
use App\Models\TaxAuthority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\TaxComponentRepository;
use App\Services\TaxComponent\TaxComponentService;
use App\Http\Requests\TaxComponent\{CreateTaxComponentRequest, UpdateTaxComponentRequest};

class TaxComponentController extends Controller
{
    protected $taxComponentService;
    public TaxComponentRepository $taxComponentRepository;

    public function __construct(TaxComponentRepository $taxComponentRepository, TaxComponentService $taxComponentService)
    {
        $this->taxComponentService    = $taxComponentService;
        $this->taxComponentRepository = $taxComponentRepository;
    }

    public function index()
    {
        $tax_authorities     = TaxAuthority::query()->pluck('authority_name', 'id');
        return view('tax_component.tax_components', compact('tax_authorities'));
    }

    public function create()
    {
        $tax_authorities     = TaxAuthority::query()->pluck('authority_name', 'id');
        $nextSortOrder = $this->taxComponentService->getNextSortOrder();
        return view('tax_component.create',compact('tax_authorities','nextSortOrder'));
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
            $this->taxComponentRepository->store($request->only('sort_order','component_name','component_tax_id','authority_id','sales_tax_id'));
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
        $tax_component = $this->taxComponentRepository->findOrFail($id);
        $tax_authorities     = TaxAuthority::query()->pluck('authority_name', 'id');
        return view('tax_component.edit', compact('tax_authorities','tax_component'));
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
            $taxComponent->update($request->only('sort_order','component_name','component_tax_id','authority_id','sales_tax_id'));
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

    public function getTaxComponentDataTableList(Request $request) {
        return $this->taxComponentRepository->dataTable($request);
    }

}
