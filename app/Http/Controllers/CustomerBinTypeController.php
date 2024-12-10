<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\CustomerBinType;
use Illuminate\Support\Facades\Log;
use App\Repositories\CustomerBinTypeRepository;
use App\Http\Requests\CustomerBinType\{CreateCustomerBinTypeRequest, UpdateCustomerBinTypeRequest};

class CustomerBinTypeController extends Controller
{
    public $customerBinTypeRepository;

    public function __construct(CustomerBinTypeRepository $customerBinTypeRepository)
    {
        $this->customerBinTypeRepository = $customerBinTypeRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerBinTypeRequest $request)
    {
        try {
            $this->customerBinTypeRepository->store($request->only('label','customer_id','type','x','y','z','length','width','height','bin_type_id','zone','entered_by_id','notes'));
            return response()->json(['status' => 'success', 'msg' => 'Bin Type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving Bin Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Bin Type.']);
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
        $model = $this->customerBinTypeRepository->findOrFail($id);
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
        $model = $this->customerBinTypeRepository->findOrFail($id);

        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerBinTypeRequest $request, CustomerBinType $customerBinType)
    {
        try {
            $this->customerBinTypeRepository->update($request->only('label','customer_id','type','x','y','z','length','width','height','bin_type_id','zone','entered_by_id','notes'), $customerBinType->id);
            return response()->json(['status' => 'success', 'msg' => 'Bin Type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating Bin Type : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the Bin Type .']);
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
            $CustomerBinType = $this->customerBinTypeRepository->findOrFail($id);
            if ($CustomerBinType) {
                $this->customerBinTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Bin Type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Bin Type not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting Bin Type : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Bin Type .']);
        }
    }

    public function getCustomerBinTypeDataTableList(Request $request) {
        return $this->customerBinTypeRepository->dataTable($request);
    }
}
