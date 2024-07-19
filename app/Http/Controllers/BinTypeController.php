<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\BinType;
use Illuminate\Http\Request;
use App\Repositories\BinTypeRepository;
use App\Http\Requests\BinType\{CreateBinTypeRequest, UpdateBinTypeRequest};

class BinTypeController extends Controller
{
    private BinTypeRepository $binTypeRepository;

    public function __construct(BinTypeRepository $binTypeRepository)
    {
        $this->binTypeRepository = $binTypeRepository;
    }
    public function index()
    {
        return view('bin_type.bin_types');
    }
    public function store(CreateBinTypeRequest $request)
    {
        try {
            $this->binTypeRepository->store($request->only('bin_type'));
            return response()->json(['status' => 'success', 'msg' => 'Bin Type saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Bin Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Bin Type.']);
        }
    }

    public function show($id)
    {
        $model = $this->binTypeRepository->findOrFail($id);
        return response()->json($model);
    }
    public function edit($id)
    {
        $model = $this->binTypeRepository->findOrFail($id);
        return response()->json($model);
    }


    public function update(UpdateBinTypeRequest $request, BinType $binType)
    {
        try {

            $this->binTypeRepository->update($request->only('bin_type'), $binType->id);
            //  $BinType->update($request->validated()); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Bin Type updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Bin Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Bin Type.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->binTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Bin Type deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Bin Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Bin Type.']);
        }
    }
    public function getBinTypeDataTable(Request $request)
    {
        return $this->binTypeRepository->dataTable($request);
    }
}
