<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\PrePurchaseTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\PrePurchaseTermRepository;
use App\Http\Requests\PrePurchaseTerm\{CreatePrePurchaseTermRequest, UpdatePrePurchaseTermRequest, ImportPrePurchaseTermRequest};

class PrePurchaseTermController extends Controller
{
    public $prePurchaseTermRepository;

    public function __construct(PrePurchaseTermRepository $prePurchaseTermRepository)
    {
        $this->prePurchaseTermRepository = $prePurchaseTermRepository;
    }

    public function index()
    {
        return view('pre_purchase_term.pre_purchase_terms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrePurchaseTermRequest $request)
    {
        try {
            $this->prePurchaseTermRepository->store($request->only('pre_purchase_term_name'));
            return response()->json(['status' => 'success', 'msg' => 'Pre Purchase Term saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving pre purchase term: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the pre purchase term.']);
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
        $model = $this->prePurchaseTermRepository->findOrFail($id);
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
        $model = $this->prePurchaseTermRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrePurchaseTermRequest $request, PrePurchaseTerm $prePurchaseTerm)
    {
        try {
            $this->prePurchaseTermRepository->update($request->only('pre_purchase_term_name'), $prePurchaseTerm->id);
            return response()->json(['status' => 'success', 'msg' => 'Pre Purchase Term updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating prePurchaseTerm: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the pre purchase term.']);
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
            $prePurchaseTerm = $this->prePurchaseTermRepository->findOrFail($id);
            if ($prePurchaseTerm) {
                $this->prePurchaseTermRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Pre Purchase Term deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'pre purchase term not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting pre purchase term: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the pre purchase term.']);
        }
    }

    public function getPrePurchaseTermDataTableList(Request $request)
    {
        return $this->prePurchaseTermRepository->dataTable($request);
    }
}
