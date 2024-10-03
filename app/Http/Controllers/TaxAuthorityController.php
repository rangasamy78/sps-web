<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Country;
use App\Models\TaxAuthority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\TaxAuthorityRepository;
use App\Http\Requests\TaxAuthority\{CreateTaxAuthorityRequest, UpdateTaxAuthorityRequest};

class TaxAuthorityController extends Controller
{
    public TaxAuthorityRepository $taxAuthorityRepository;

    public function __construct(TaxAuthorityRepository $taxAuthorityRepository)
    {
        $this->taxAuthorityRepository = $taxAuthorityRepository;
    }

    public function index()
    {
        return view('tax_authority.tax_authorities');
    }

    public function create()
    {
        $countries     = Country::query()->pluck('country_name', 'id');
        return view('tax_authority.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaxAuthorityRequest $request)
    {
        try {
            $this->taxAuthorityRepository->store($request->only('authority_name','print_name','authority_code','contact_name','primary_phone','secondary_phone','mobile','fax','email','website','address','suite','city','state','zip','country_id','tax_number','check_memo','internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Tax Authority saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving tax authority: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the tax authority.']);
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
        $tax_authority = $this->taxAuthorityRepository->findOrFail($id);
        return view('tax_authority.show', compact('tax_authority'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax_authority = $this->taxAuthorityRepository->findOrFail($id);
        $countries     = Country::query()->pluck('country_name', 'id');
        return view('tax_authority.edit', compact('countries','tax_authority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxAuthorityRequest $request, TaxAuthority $taxAuthority)
    {
        try {
            $this->taxAuthorityRepository->update($request->only('authority_name','print_name','authority_code','contact_name','primary_phone','secondary_phone','mobile','fax','email','website','address','suite','city','state','zip','country_id','tax_number','check_memo','internal_notes'),$taxAuthority->id);
            return response()->json(['status' => 'success', 'msg' => 'Tax Authority updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating tax authority: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating tax authority.']);
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
            $taxAuthority = $this->taxAuthorityRepository->findOrFail($id);
            if ($taxAuthority) {
                $this->taxAuthorityRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Tax Authority deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Tax Authority not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting tax authority: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting tax authority.']);
        }
    }

    public function getTaxAuthorityDataTableList(Request $request) {
        return $this->taxAuthorityRepository->dataTable($request);
    }

}
