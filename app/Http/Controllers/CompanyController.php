<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\CompanyRepository;
use App\Http\Requests\Company\{CreateCompanyRequest, UpdateCompanyRequest};

class CompanyController extends Controller
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $companyCount = Company::query()->count();
        return view('company.companies', compact('companyCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompanyRequest $request)
    {
        try {
            $company = $this->companyRepository->store($request->only('company_name','email','address_line_1','address_line_2','city','state','zip','phone_1','phone_2','website','logo','is_bin_pre_defined'));
            $count   = Company::query()->count();
            return response()->json(['status' => 'success', 'msg' => 'Company saved successfully.', 'company_logo' => isset($company) ? $company->logo : '', 'companyCount' => $count]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving company: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the company.']);
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
        $model = $this->companyRepository->findOrFail($id);
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
        $model = $this->companyRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        try {
            $company = $this->companyRepository->update($request->only('company_name','email','address_line_1','address_line_2','city','state','zip','phone_1','phone_2','website','logo','is_bin_pre_defined'), $id); // Use validated data
            return response()->json(['status' => 'success', 'msg' => 'Company updated successfully.', 'company_logo' => isset($company) ? $company->logo : '' ]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating company: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the company.']);
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
            $company = $this->companyRepository->findOrFail($id);
            if ($company) {
                $this->companyRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Company deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Company not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting company: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the company.']);
        }
    }

    public function getCompanyDataTableList(Request $request) {
        return $this->companyRepository->dataTable($request);
    }

    public function getCompanyCount()
    {
        $count = Company::query()->count();
        return response()->json(['count' => $count]);
    }
}
