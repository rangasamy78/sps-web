<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorPoNewBill;
use App\Repositories\FreightBillRepository;

class FreightBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private FreightBillRepository $freightBillRepository;

    public function __construct(FreightBillRepository $freightBillRepository)
    {
        $this->freightBillRepository = $freightBillRepository;
    }

    public function index()
    {
        return view('freight_bill.freight_bills');
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
    public function update(Request $request, VendorPoNewBill $vendorNewbill)
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
    public function getFreightBillDataTableList(Request $request)
    {
        return $this->freightBillRepository->dataTable($request);
    }
}