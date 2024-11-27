<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Repositories\FreightVendorRepository;

class FreightVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private FreightVendorRepository $freightVendorRepository;

    public function __construct(FreightVendorRepository $freightVendorRepository)
    {
        $this->freightVendorRepository = $freightVendorRepository;
    }

    public function index()
    {
        return view('freight_vendor.freight_vendors');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenditure $expenditure)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function getFreightVendorDataTableList(Request $request)
    {
       
        return $this->freightVendorRepository->dataTable($request);
    }
}