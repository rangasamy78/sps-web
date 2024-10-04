<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ServiceTypeRepository;
use App\Http\Requests\ServiceType\{CreateServiceTypeRequest, UpdateServiceTypeRequest};


class ServiceTypeController extends Controller
{
    private ServiceTypeRepository $serviceTypeRepository;

    public function __construct(ServiceTypeRepository $serviceTypeRepository)
    {
        $this->serviceTypeRepository = $serviceTypeRepository;
    }

    public function index()
    {
        return view('service_type.service_types');
    }

    public function store(CreateServiceTypeRequest $request)
    {
        try {
            $this->serviceTypeRepository->store($request->only('service_type'));
            return response()->json(['status' => 'success', 'msg' => 'Service Type saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving service type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the service type.']);
        }
    }

    public function show($id)
    {
        $model = $this->serviceTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->serviceTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateServiceTypeRequest $request, ServiceType $serviceType)
    {
        try {
            $this->serviceTypeRepository->update($request->only('service_type'), $serviceType->id);
            return response()->json(['status' => 'success', 'msg' => 'Service Type updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating service type: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the service type.']);
        }
    }

    public function destroy($id)
    {
        try {
            $serviceType = $this->serviceTypeRepository->findOrFail($id);
            if ($serviceType) {
                $this->serviceTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Service Type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Service Type not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Service Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the service type.']);
        }
    }

    public function getServiceTypeDataTableList(Request $request)
    {
        return $this->serviceTypeRepository->dataTable($request);
    }
}
