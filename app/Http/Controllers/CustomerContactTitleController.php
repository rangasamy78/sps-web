<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CustomerContactTitle;
use App\Repositories\CustomerContactTitleRepository;
use App\Http\Requests\CustomerContactTitle\{CreateCustomerContactTitleRequest, UpdateCustomerContactTitleRequest};

class CustomerContactTitleController extends Controller
{
    private CustomerContactTitleRepository $customerContactTitleRepository;
    public function __construct(CustomerContactTitleRepository $customerContactTitleRepository)
    {
        $this->customerContactTitleRepository = $customerContactTitleRepository;
    }
    public function index()
    {
        return view('customer_contact_title.customer_contact_titles');
    }
    public function store(CreateCustomerContactTitleRequest $request)
    {
        try {
            $this->customerContactTitleRepository->store($request->only('customer_title'));
            return response()->json(['status' => 'success', 'msg' => 'Customer contact title saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving customer contact title: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the customer contact title.']);
        }
    }
    public function show($id)
    {
        $model = $this->customerContactTitleRepository->findOrFail($id);
        return response()->json($model);
    }
    public function edit($id)
    {
        $model = $this->customerContactTitleRepository->findOrFail($id);
        return response()->json($model);
    }
    public function update(UpdateCustomerContactTitleRequest $request, CustomerContactTitle $customerContactTitle)
    {
        try {
            $this->customerContactTitleRepository->update($request->only('customer_title'), $customerContactTitle->id);
            return response()->json(['status' => 'success', 'msg' => 'Customer contact title updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating customer contact title: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the customer contact title.']);
        }
    }

    public function destroy($id)
    {
        try {
            $customerContactTitle = $this->customerContactTitleRepository->findOrFail($id);
            if ($customerContactTitle) {
                $this->customerContactTitleRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Customer contact title deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Customer contact title not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting customer contact title: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the customer contact title.']);
        }
    }
    public function getCustomerContactTitleDataTableList(Request $request)
    {
        return $this->customerContactTitleRepository->dataTable($request);
    }
}
