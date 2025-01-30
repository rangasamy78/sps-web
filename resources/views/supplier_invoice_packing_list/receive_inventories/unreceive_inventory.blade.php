@extends('layouts.admin')
@section('title', 'PO Details')
@section('styles')
<style>
    /* Add custom styles for the page if needed */
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>
            <span>
            Supplier Invoice</span>
        </h4>
        <input type="hidden" name="po_id" id="po_id" value="{{ $supplier_invoice->po_id ?? '' }}">
        <input type="hidden" name="id" id="id" value="{{ $supplier_invoice->id ?? '' }}">
        <input type="hidden" name="po_location" id="po_location" value="{{ $supplier_invoice->location->company_name ?? '' }}">

        
        <div class="app-ecommerce">
            <div class="row">
                <!-- First Column -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                           

                            <!-- Freight Bills Table -->
                            <div class="tab-pane fade show active" id="crm" role="tabpanel"><br>
                              
                                <table class="datatables-basic table tables-basic border-top table-striped" id="crm">
                                    <thead class="table-header-bold">
                                        <tr>
                                            <th>Pkg List ID</th>
                                            <th>P.O#</th>
                                            <th>Entry Date</th>
                                            <th>Sup.Invoice#</th>
                                            <th>Container#</th>
                                            <th>Supplier</th>
                                            <th>Ship To</th>
                                            <th>Ship Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="UnreceiveData">
                                    </tbody>
                                    
                                </table>
                            </div>

                           

                            <!-- Received Date and Button -->
                            <div class="row mt-4">
                             
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary" id="unreceiveInvoiceButton">
                                        Unreceive Inventory
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /First Column -->
            </div>
        </div>
    </div>
    <!-- /Content -->
    <div class="content-backdrop fade"></div>
</div>
@endsection

@section('scripts')
@include('supplier_invoice_packing_list.receive_inventories.__scripts')

@endsection
