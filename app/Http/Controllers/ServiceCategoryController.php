<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Log;
use App\Repositories\ServiceCategoryRepository;
use App\Http\Requests\ServiceCategory\{CreateServiceCategoryRequest, UpdateServiceCategoryRequest};


class ServiceCategoryController extends Controller
{
    private ServiceCategoryRepository $serviceCategoryRepository;

    public function __construct(ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function index()
    {
        return view('service_category.service_categories');
    }

    public function store(CreateServiceCategoryRequest $request)
    {
        try {
            $this->serviceCategoryRepository->store($request->only('service_category'));
            return response()->json(['status' => 'success', 'msg' => 'Service Category saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving service category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the service category.']);
        }
    }

    public function show($id)
    {
        $model = $this->serviceCategoryRepository->findOrFail($id);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = $this->serviceCategoryRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {
        try {
            $this->serviceCategoryRepository->update($request->only('service_category'), $serviceCategory->id);
            return response()->json(['status' => 'success', 'msg' => 'Service Category updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating service category: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the service category.']);
        }
    }

    public function destroy($id)
    {
        try {
            $serviceCategory = $this->serviceCategoryRepository->findOrFail($id);
            if ($serviceCategory) {
                $this->serviceCategoryRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Service Category deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Service Category not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting Service Category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the service category.']);
        }
    }

    public function getServiceCategoryDataTableList(Request $request)
    {
        return $this->serviceCategoryRepository->dataTable($request);
    }
}
