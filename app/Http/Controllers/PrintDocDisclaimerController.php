<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\PrintDocDisclaimer;
use Illuminate\Support\Facades\Log;
use App\Services\PrintDocDisclaimer\PrintDocDisclaimerService;
use App\Repositories\{ PrintDocDisclaimerRepository, DropDownRepository };
use App\Http\Requests\PrintDocDisclaimer\{CreatePrintDocDisclaimerRequest, UpdatePrintDocDisclaimerRequest};

class PrintDocDisclaimerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $dropDownRepository;
    public $printDocDisclaimerService;
    public $printDocDisclaimerRepository;

    public function __construct(PrintDocDisclaimerRepository $printDocDisclaimerRepository, DropDownRepository $dropDownRepository,PrintDocDisclaimerService $printDocDisclaimerService)
    {
        $this->dropDownRepository = $dropDownRepository;
        $this->printDocDisclaimerRepository = $printDocDisclaimerRepository;
        $this->printDocDisclaimerService = $printDocDisclaimerService;
    }

    public function index()
    {
        $select_type_categories = $this->dropDownRepository->dropDownPopulate('select_type_categories');
        return view('print_doc_disclaimer.print_doc_disclaimers', compact('select_type_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreatePrintDocDisclaimerRequest $request)
    {
        try {
            $this->printDocDisclaimerRepository->store($request->only('title', 'select_type_category_id', 'select_type_sub_category_id', 'policy'));
            return response()->json(['status' => 'success', 'msg' => 'Print Doc Disclaimer saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Print Doc Disclaimer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Print Doc Disclaimer.']);
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
        $model = $this->printDocDisclaimerRepository->findOrFail($id);
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
        $model = $this->printDocDisclaimerRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrintDocDisclaimerRequest $request, PrintDocDisclaimer $printDocDisclaimer)
    {
        try {
            $data = $request->only('title', 'select_type_category_id', 'select_type_sub_category_id', 'policy');
            $this->printDocDisclaimerRepository->update($data, $printDocDisclaimer->id);
            return response()->json(['status' => 'success', 'msg' => 'Print Doc Disclaimer updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Print Doc Disclaimer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Print Doc Disclaimer.']);
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
            $this->printDocDisclaimerRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Print Doc Disclaimer deleted successfully.']);
            } 
            catch (Exception $e) {
            Log::error('Error deleting Print Doc Disclaimer: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Print Doc Disclaimer.']);
        }
    }

    public function getPrintDocDisclaimerDataTableList(Request $request)
    {
        return $this->printDocDisclaimerRepository->dataTable($request);
    }

    public function getSubCategories(Request $request)
    {
        return $this->printDocDisclaimerService->getSubCategories($request);
    }   
}