<?php

namespace App\Http\Controllers;

use App\Http\Requests\Associate\CreateAssociateRequest;
use App\Http\Requests\Associate\UpdateAssociateRequest;
use App\Models\Associate;
use App\Models\Company;
use App\Models\Country;
use App\Models\County;
use App\Models\CustomerType;
use App\Models\User;
use App\Repositories\AssociateRepository;
use Exception;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Log;

class AssociateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private AssociateRepository $associateRepository;

    public function __construct(AssociateRepository $associateRepository)
    {
        $this->associateRepository = $associateRepository;
    }

    public function index()
    {
        $associate_type = CustomerType::all();
        return view('associate.associates', compact('associate_type'));

    }
    public function create()
    {

        $primary_sale = User::whereHas('department', function ($query) {
            $query->where('department_name', 'Sales');
        })->get();
        $secondary_sale = User::whereHas('department', function ($query) {
            $query->where('department_name', 'Sales');
        })->get();

        $county         = County::query()->get();
        $company        = Company::query()->get();
        $country        = Country::query()->get();
        $associate_type = CustomerType::query()->get();
        return view('associate.__create', compact('company', 'associate_type', 'country', 'county', 'primary_sale', 'secondary_sale'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateAssociateRequest $request)
    {
        try {
            $this->associateRepository->store($request->only('associate_name', 'associate_code', 'associate_type_id', 'contact_name',
                'referred_by_id', 'primary_phone', 'secondary_phone', 'mobile', 'fax', 'email', 'accounting_email', 'website', 'address', 'suite', 'country_id', 'city', 'state', 'zip', 'location_id', 'route_id',
                'primary_sales_id', 'secondary_sales_id', 'internal_notes'));
            return response()->json(['status' => 'success', 'msg' => 'Associate saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving associate: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the associate.']);
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
        $associate = Associate::findOrFail($id);
        $countyies = County::query()->get();
        $countries = Country::query()->get();

        return view('associate.__show', compact('associate', 'countries', 'countyies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $associate    = Associate::findOrFail($id);
        $primary_sale = User::whereHas('department', function ($query) {
            $query->where('department_name', 'Sales');
        })->get();

        $secondary_sale = User::whereHas('department', function ($query) {
            $query->where('department_name', 'Sales');
        })->get();

        $county         = County::all();
        $company        = Company::all();
        $country        = Country::all();
        $associate_type = CustomerType::all();

        return view('associate.__edit', compact('associate', 'company', 'associate_type', 'country', 'county', 'primary_sale', 'secondary_sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssociateRequest $request, Associate $associate)
    {
        try {
            $this->associateRepository->update($request->only('associate_name', 'associate_code', 'associate_type_id', 'contact_name',
                'referred_by_id', 'primary_phone', 'secondary_phone', 'mobile', 'fax', 'email', 'accounting_email', 'website', 'address', 'suite', 'country_id', 'city', 'state', 'zip', 'location_id', 'route_id',
                'primary_sales_id', 'secondary_sales_id', 'internal_notes'), $associate->id);
            return response()->json(['status' => 'success', 'msg' => 'Associate updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating associate: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the associate.']);
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
            $associate = $this->associateRepository->findOrFail($id);
            if ($associate) {

                if ($associate->status == 0) {
                    return response()->json(['status' => 'false', 'msg' => 'Associate is already inactive.']);
                }
                $associate->status = 0;
                $associate->save();

                return response()->json(['status' => 'success', 'msg' => 'Associate marked as inactive.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Associate not found.']);
            }
        } catch (Exception $e) {

            Log::error('Error updating associate status: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the associate status.']);
        }
    }

    public function getAssociateDataTableList(Request $request)
    {
        return $this->associateRepository->dataTable($request);
    }
    public function associateChangeStatus($id)
    {
        try {
            $associate = $this->associateRepository->findOrFail($id);

            $newStatus         = $associate->status == 1 ? 0 : 1;
            $associate->status = $newStatus;
            $associate->save();

            return response()->json([
                'status'     => 'success',
                'new_status' => $newStatus,
                'msg'        => 'Status updated successfully.',
            ]);
        } catch (Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'msg'    => 'Failed to update status.',
            ], 500);
        }
    }

}
