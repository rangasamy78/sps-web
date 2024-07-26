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
            return response()->json(['status' => 'success', 'msg' => 'Customer Contact Title saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving Customer Contact Title: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the Customer Contact Title.']);
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
            return response()->json(['status' => 'success', 'msg' => 'Customer Contact Title updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating Customer Contact Title: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the Customer Contact Title.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->customerContactTitleRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'Customer Contact Title deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting Customer Contact Title: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the Customer Contact Title.']);
        }
    }
    public function getCustomerContactTitleDataTableList(Request $request)
    {
        return $this->customerContactTitleRepository->dataTable($request);
    }
}
