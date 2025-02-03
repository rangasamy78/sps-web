@extends('layouts.admin')
@section('title', 'PO Details')
@section('styles')
<style>
.status-bar {
    display: flex;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background-color: #f9f9f9;
    width: 220px;
    height: 30px;
}

.status-item {
    flex: 1;
    padding: 5px 0;
    text-align: center;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 12px;
    background-color: #b9b8ab; /* Default grey background for all items */
    color: white; /* Text color */
}

.status-item.active {
    background-color: #28a745; /* Green for active status */
}

.status-item.inactive {
    background-color: #b9b8ab; /* Grey for inactive statuses */
}
</style>

@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> PO /</span><span>Purchase Order</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="row mb-2">
               
                                        <div class="col">

                                            <label for="Type"><span class="text-dark fw-bold">Purchase Order#:
                                                </span><span>{{ $purchase_order->po_number ?? '' }} </span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Location"><span class="text-dark fw-bold"> </span><span><?php
$formattedDate = $purchase_order->po_date ? \Carbon\Carbon::parse($purchase_order->po_date)->format('d-m-Y') : ''; ?>
                                                    <label><span
                                                            class="text-dark fw-bold">&nbsp;</span>{{ $formattedDate ?? '' }}</label></span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Parent Location"><span class="text-dark fw-bold">Supplier:
                                                </span><span> {{ $purchase_order->supplier->supplier_name ?? '' }}<br>
                                                    {{ $purchase_order->supplier_address_id ?? '' }}<br>
                                                    {{ $purchase_order->supplier_address ?? '' }}<br>{{ $purchase_order->supplier_suite ?? '' }}</span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Payment Terms"><span class="text-dark fw-bold">Ship To:
                                                </span><span>{{ $purchase_order->ship_locations->company_name ?? '' }}<br>{{ $purchase_order->purchase_location_address ?? '' }}<br>{{ $purchase_order->purchase_location_suite ?? '' }}<br>{{ $purchase_order->purchase_location_city ?? '' }}<br></span></label>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        
                                        <div class="col">
                                            <label for="supplier_name">
                                                <span class="text-dark fw-bold">Purchase Location
                                                    :</span><span>
                                                    {{ $purchase_order->location->company_name ?? '' }}</span>

                                            </label>
                                        </div>
                                     
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Payment
                                                    Terms:</span><span>
                                                    {{ $purchase_order->payment_terms->payment_label ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Shipment
                                                    Terms:</span><span>
                                                    {{ $purchase_order->shipment_term->shipment_term_name ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">P.O.
                                                    Terms:</span><span> {!! $purchase_order->terms ?? '' !!}</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="col">
                                        <div class="row mb-2">
                                        <div class="col">
                                        <label for="purchase_order_status" class="text-dark fw-bold">Status:</label>
                                        <div class="status-bar">
                                            <span id="pendingStatus" class="status-item">Pending</span>
                                            <span id="fulfilledStatus" class="status-item">0% Fulfilled</span>
                                            <span id="closedStatus" class="status-item">Closed</span>
                                        </div>
                                        <input type="hidden" name="po_id" id="po_id" value="{{ $purchase_order->id }}">
                                        <input type="hidden" name="po_status" id="po_status" value="{{ $purchase_order->status }}">
                                        <a href="javascript:void(0);" class="btn btn-info mt-2 w-50 text-center rounded" style="padding: 5px 10px; font-size: 14px;" id="closePOBtn">Close PO</a>
                                    </div>

                                          
                                        </div>
                                        <div class="col-6">
                                   <div id="parent-container"></div>
                                 
                                        </div>

                                    </div>
                                    </div>

                                <di<div class="row mb-2">
                                <!-- Internal Notes Section -->
                                <label for="primary_phone">
                                    <span class="text-dark fw-bold">Add Internal Notes:</span>
                                    <span>{{ $purchase_order->internal_notes ?? '' }}</span>
                                </label>
                                <div class="col-6">
                                    <div id="pointernalData"></div>
                                    <div class="mt-2">
                                        <span class="text-danger error-text po_internal_notes_error"></span>
                                        <form id="pointernalNoteForm" name="pointernalNoteForm" method="POST" action="/save-internal-notes" class="form-horizontal">
                                            <input type="hidden" name="po_internal_note_id" id="po_internal_note_id">
                                            <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="{{ $purchase_order->id }}">
                                            <textarea class="form-control" name="po_internal_notes" id="po_internal_notes" cols="50" rows="2" maxlength="500" placeholder="Enter internal notes here..."></textarea>
                                            <button type="submit" class="btn btn-primary mt-2" id="po_internal_save_data" name="po_internal_save_data">Save</button>
                                        </form>
                                    </div>
                                </div>

                              
                                

                                <div class="row">
                   
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label for="special_instructions" class="text-dark fw-bold">Printed Notes:</label>
                                        <input type="text" name="special_instructions"
                                            class="form-control" value=" {{ $purchase_order->printed_notes ?? '' }}" />
                       
                  
                                    </div>
                                    
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label for="special_instructions" class="text-dark fw-bold">Special
                                            Instructions:</label>
                                            <input type="text" name="special_instructions"
                                            class="form-control" value=" {{ $purchase_order->special_instructions ?? '' }}" />
                                      
                                    </div>
                                    
                                </div>
                                <input type="hidden" name="po_id" id="po_id"
                                value="{{ $purchase_order->id ?? '' }}">
                                
                                <input type="hidden" name="approval_status" id="approval_status"
                                value="{{ $purchase_order->approval_status ?? '' }}">

                                <input type="hidden" name="approved_state" id="approved_state"
                                value="{{ $purchase_order->approved_state ?? '' }}">
                                
                                <input type="hidden" name="approval_date" id="approval_date"
                                value="{{ $purchase_order->approval_date ?? '' }}">
                                <input type="hidden" name="approval_note" id="approval_note"
                                value="{{ $purchase_order->approval_status_note ?? '' }}">

                                <input type="hidden" name="approval_status_note" id="approval_status_note"
                                value="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /first column -->
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header"><strong>Supplier Invoice/Packing Lists</strong></div>
                    <div class="card-body" style="padding: 0;">
                        <div style="overflow-x: auto;">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="card pt-0 p-4">
                                        <div class="row">
                                            <div class="col">
                                              
                                                <table
                                                    class="datatables-basic table tables-basic border-top table-striped"
                                                    id="supplierInvoiceTable">
                                                    <thead class="table-header-bold">
                                                        <tr class="odd gradeX">
                                                            <th>Date</th>
                                                            <th>Transaction</th>
                                                            <th>Invoice# </th>
                                                            <th>Total</th>
                                                            <th>ETA Date </th>
                                                            <th>Received Date </th>
                                                            <th>Container# </th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 order-0 order-md-1">
                    <!-- Navigation -->
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item me-3">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#product_details">

                                        <span class="align-middle">Products</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">

                                        <span class="align-middle">Files</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">

                                        <span class="align-middle">CRM</span>
                                    </button>
                                </li>

                            </ul>
                            <div class="ms-auto">
                            <button class="btn btn-primary" id="addMoreLinesBtn">Add More Lines</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                        <div class="tab-pane fade show active" id="product_details">
                                            @include('purchase_order.product_po.product_po_details')
                                        </div>
                                        <div class="tab-pane fade" id="files">
                                            @include('purchase_order.product_file.files')
                                        </div>
                                        <div class="tab-pane fade" id="crm">
                                            @include('purchase_order.product_crm.crm')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')

@include('purchase_order.__scripts')
@include('purchase_order.purchase_order_details.__scripts')
@include('purchase_order.po_internal_notes.__scripts')

@endsection