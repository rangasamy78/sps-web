<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrderProduct;
use App\Models\SupplierInvoicePackingItem;

class SupplierInvoicePackingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poProducts = PurchaseOrderProduct::query()->where('po_id', 4) ->with(['product'])->get();
        // dd($poProducts);
        return view('supplier_invoice.packing_items', compact('poProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplierInvoicePackingItem $supplierInvoicePackingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplierInvoicePackingItem $supplierInvoicePackingItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupplierInvoicePackingItem $supplierInvoicePackingItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierInvoicePackingItem $supplierInvoicePackingItem)
    {
        //
    }
}
