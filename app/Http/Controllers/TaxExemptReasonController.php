<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\TaxExemptReason;
use Illuminate\Support\Facades\Log;
use App\Repositories\TaxExemptReasonRepository;
use App\Http\Requests\TaxExemptReason\{CreateTaxExemptReasonRequest, UpdateTaxExemptReasonRequest};

class TaxExemptReasonController extends Controller
{
    private TaxExemptReasonRepository $taxExemptReasonRepository;

    public function __construct(TaxExemptReasonRepository $taxExemptReasonRepository)
    {
        $this->taxExemptReasonRepository = $taxExemptReasonRepository;
    }

    public function index()
    {
        return view('tax_exempt_reason.tax_exempt_reasons');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaxExemptReasonRequest $request)
    {
        try {
            $this->taxExemptReasonRepository->store($request->only('reason'));
            return response()->json(['status' => 'success', 'msg' => 'Tax exempt reason saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving tax exempt reason : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the tax exempt reason .']);
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
        $model = $this->taxExemptReasonRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->taxExemptReasonRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxExemptReasonRequest $request, TaxExemptReason $taxExemptReason)
    {
        try {
            $this->taxExemptReasonRepository->update($request->only('reason'), $taxExemptReason->id);
            return response()->json(['status' => 'success', 'msg' => 'Tax exempt reason  updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating tax exempt reason: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the tax exempt reason.']);
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
            $taxExemptReason = $this->taxExemptReasonRepository->findOrFail($id);
            if ($taxExemptReason) {
                $this->taxExemptReasonRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Tax exempt reason deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Tax exempt reason number not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting tax exempt reason: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the tax exempt reason.']);
        }
    }

    public function getTaxExemptReasonDataTableList(Request $request)
    {
        return $this->taxExemptReasonRepository->dataTable($request);
    }
}
