<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\BinType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            return response()->json(['status' => 'success', 'msg' => 'Bin type saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving bin type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the bin type.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Bin type updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating bin type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the bin type.']);
        }
    }

    public function destroy($id)
    {
        try {
            $binType = $this->binTypeRepository->findOrFail($id);
            if ($binType) {
                $this->binTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Bin type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Bin type not found.']);
            }            
        } catch (Exception $e) {
            Log::error('Error deleting bin type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the bin type.']);
        }
    }
    public function getBinTypeDataTable(Request $request)
    {
        return $this->binTypeRepository->dataTable($request);
    }
}
