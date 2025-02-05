@extends('layouts.admin')
@section('title', 'PO Details')
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> </span><span>Supplier Invoice/Packing List#:
                {{ $supplier_invoice->po_number ?? '' }}</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Type"><span class="text-dark fw-bold">1. Packing List Entry
                                                </span> </label>
                                            <div class="form-group">
                                                <label for="Type">
                                                    <a href="<?php echo route('supplier_invoice_packing_items.index', ['po_id' => $supplier_invoice->po_id ?? '', 'id' => $supplier_invoice->id ?? '']); ?>" style="color: black; margin-left: 20px;">Enter Packing List</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Type"><span class="text-dark fw-bold">2. Pre-receiving Process
                                                </span>
                                            </label>

                                            <label for="Type">
                                                <a href="#" style="color: black; margin-left: 20px;">Update
                                                    Allocation/Sup.BarcodeID</a>
                                            </label>
                                            <label for="Type">
                                                <a href="#" style="color: black; margin-left: 20px;">Print Receiving
                                                    Worksheet</a>
                                            </label>
                                            <label for="Type">
                                                <a href="#" style="color: black; margin-left: 20px;">Print Receiving
                                                    Worksheet No Sizes</a>
                                            </label>
                                            <div class="row">
                                                <label for="Type">
                                                    <a href="#" style="color: black; margin-left: 20px;">Print
                                                        Barcodes</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Type"><span class="text-dark fw-bold">3. Receive Inventory
                                                </span> </label>
                                            <div class="form-group">
                                                <label for="Type">
                                                    <a href="#" style="color: black; margin-left: 20px;">Receive
                                                        Inventory</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Type"><span class="text-dark fw-bold">4. Payments </span>
                                            </label>
                                            <div class="form-group">
                                                <label for="Type">
                                                    <a href="#" style="color: black; margin-left: 20px;">Pay Inventory
                                                        Bill</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Location"><span class="text-dark fw-bold"> Created By on
                                                    :</span><span class="text">
                                                    <?php $formattedDate = $supplier_invoice->po_date ? \Carbon\Carbon::parse($supplier_invoice->po_date)->format('d-m-Y') : ''; ?>
                                                    <label><span
                                                            class="text-dark fw-bold">&nbsp;</span>{{ $formattedDate ?? '' }}</span></label></span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Location"><span class="text-dark fw-bold"> Created From
                                                    PO#:</span><span class="text">
                                                    <?php $formattedDate = $supplier_invoice->po_date ? \Carbon\Carbon::parse($supplier_invoice->po_date)->format('d-m-Y') : ''; ?></span>
                                                <label><span
                                                        class="text-dark fw-bold">&nbsp;</span>{{ $formattedDate ?? '' }}</label></span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Parent Location"><span class="text-dark fw-bold">Supplier:
                                                </span><span
                                                    class="text">{{ $supplier_invoice->supplier->supplier_name ?? '' }}<br>
                                                    {{ $supplier_invoice->supplier_address_id ?? '' }}<br>
                                                    {{ $supplier_invoice->supplier_address ?? '' }}<br>{{ $supplier_invoice->supplier_suite ?? '' }}</span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name">
                                                <span class="text-dark fw-bold">Purchase Location:</span><span
                                                    class="text">
                                                    :{{ $supplier_invoice->payment_term_id ?? '' }}</span>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span
                                                    class="text-dark fw-bold">Invoice#:</span><span
                                                    class="text">{{ $supplier_invoice->invoice ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Ship(B/L)
                                                    Date:</span><span
                                                    class="text">{{ $supplier_invoice->ship_date ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Payment Terms"><span class="text-dark fw-bold">Ship
                                                    To:</span><span class="text">
                                                    {{ $supplier_invoice->ship_to_location_id ?? '' }}<br>{{ $supplier_invoice->purchase_location_address ?? '' }}<br>{{ $supplier_invoice->purchase_location_suite ?? '' }}<br>{{ $supplier_invoice->purchase_location_city ?? '' }}<br></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Inv. Date:
                                                </span><span
                                                    class="text">{{ $supplier_invoice->invoice_date ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Due Date:
                                                </span><span class="text">{{ $supplier_invoice->due_date ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Payment
                                                    Terms:</span><span
                                                    class="text">{{ $supplier_invoice->payment_term_id ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Freight
                                                    Forwarder:
                                                    {{ $supplier_invoice->freight_forwarder_id ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Air Bill#:
                                                    {{ $supplier_invoice->air_bill ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Planned Ex
                                                    Factory / Ex Factory Date:
                                                    {{ $supplier_invoice->planned_ex_factory ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Departure / ETD
                                                    Port:
                                                    {{ $supplier_invoice->etd_port ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Arrival / ETA
                                                    Port:
                                                    {{ $supplier_invoice->eta_port ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Discharge Port:
                                                    {{ $supplier_invoice->discharge_port_id ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Arrival / ETA
                                                    Port:
                                                    {{ $supplier_invoice->eta_port ?? '' }}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Shipment
                                                    Terms:</span><span
                                                    class="text">{{ $supplier_invoice->shipment_term_id ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">P.O.
                                                    Terms:</span><span
                                                    class="text">{{ $supplier_invoice->payment_term_id ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Internal
                                                    Notes:{{ $supplier_invoice->shipment_term_id ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Printed
                                                    Notes:{{ $supplier_invoice->shipment_term_id ?? '' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Add Internal
                                                    Notes:</span> </label>
                                            <input type="text" class="form-control" id="internal_note" placeholder=""
                                                name="internal_note" aria-label="" />
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="primary_phone"><span class="text-dark fw-bold">Add Printed
                                                    Notes:</span> </label>
                                            <input type="text" class="form-control" id="printed_note" placeholder=""
                                                name="printed_note" aria-label="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="invoice-summary">
                                        <p><strong>Invoice Total:</strong> $90.00</p>
                                        <p><strong>Applied Payments:</strong> $0.00</p>
                                        <p><strong>Balance Due:</strong> $90.00</p>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>



                <!-- /first column -->
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

                                        <span class="align-middle">Items</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#charges">

                                        <span class="align-middle">Freight Bills</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#charges">

                                        <span class="align-middle">Containers</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#charges">

                                        <span class="align-middle">Files</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#charges">

                                        <span class="align-middle">CRM</span>
                                    </button>
                                </li>

                            </ul>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                        <div class="tab-pane fade show active" id="product_details">

                                        </div>
                                        <div class="tab-pane fade" id="charges">

                                        </div>
                                        <div class="tab-pane fade" id="charges">

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
@endsection
