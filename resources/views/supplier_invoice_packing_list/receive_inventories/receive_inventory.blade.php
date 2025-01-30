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
            <span>Receive Inventory for Packinglist#: {{ $supplier_invoice->sipl_bill ?? '' }}</span>
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
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Type">
                                                <span class="text-dark fw-bold">Supplier:</span> 
                                                {{ $supplier_invoice->supplier->supplier_name ?? '' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Type">
                                                <span class="text-dark fw-bold">Location:</span>
                                                {{ $supplier_invoice->location->company_name ?? '' }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Freight Bills Table -->
                            <div class="tab-pane fade show active" id="crm" role="tabpanel"><br>
                                <h5 class="mb-4 text-dark fw-bold">Freight Bills</h5>
                                <table class="datatables-basic table tables-basic border-top table-striped" id="crm">
                                    <thead class="table-header-bold">
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Invoice Date</th>
                                            <th>Vendor</th>
                                            <th>By Qty./Weight</th>
                                            <th>Freight Extended</th>
                                        </tr>
                                    </thead>
                                    <tbody id="freightBills">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">Total</td>
                                            <td>$00.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Materials Purchased Table -->
                            <div class="tab-pane fade show active" id="crm" role="tabpanel"><br>
                                <h5 class="mb-4 text-dark fw-bold">Materials Purchased</h5>
                                <table class="datatables-basic table tables-basic border-top table-striped" id="crm">
                                    <thead class="table-header-bold">
                                        <tr>
                                            <th>Product</th>
                                            <th></th>
                                            <th>Billed Qty</th>
                                            <th>FOB Unit Cost</th>
                                            <th>Total Cost(A)</th>
                                            <th>Pkg.List Qty</th>
                                            <th>Recvd. Qty(B)</th>
                                            <th>Net Unit Cost(C = A/B)</th>
                                            <th>By Qty./Weight</th>
                                            <th>Total Freight</th>
                                            <th>Unit Freight (E = D/B)</th>
                                            <th>Unit Landed Cost(F = C+E)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productData">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th id="totalBilledQty"></th>
                                            <th></th>
                                            <th id="totalCost"></th>
                                            <th></th>
                                            <th id="totalReceivedQty"></th>
                                            <th></th>
                                            <th></th>
                                            <th id="totalFreight"></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Received Date and Button -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <label for="receivedDate" class="form-label text-dark fw-bold">Received Date</label>
                                    <input type="date" class="form-control" id="receivedDate" name="received_date" required>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary" id="receiveInvoiceButton">
                                        Receive Supplier Invoice
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
