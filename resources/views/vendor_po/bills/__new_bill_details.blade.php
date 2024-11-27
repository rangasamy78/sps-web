@extends('layouts.admin')
@section('title', 'Show Vendor PO')
@section('styles')

@endsection
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Vendor PO /</span><span> Bill Details</span></h4>
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
                                            <label for="Vendor PO"><span class="text-dark fw-bold">Invoice
                                                    #:{{$vendor_bills->invoice_number ?? ''}}</span> </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Date"><span class="text-dark fw-bold">Date :</span> </label>
                                            <?php
                                        $formattedDate = $vendor_bills->invoice_date ? \Carbon\Carbon::parse($vendor_bills->invoice_date)->format('d-m-Y') : ''; ?>
                                            <label for=""><span class="text-dark fw-bold">
                                                    &nbsp;</span>{{ $formattedDate ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Date"><span class="text-dark fw-bold">Transaction#:</span>
                                            </label>
                                            <label for=""><span class="text-dark fw-bold">
                                                    &nbsp;</span>{{$vendor_bills->transaction_number ?? ''}}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Date"><span class="text-dark fw-bold">Created from#:Vendor
                                                    PO#:</span> </label>
                                            <label for=""><span class="text-dark fw-bold">
                                                    &nbsp;</span>{{$vendor_bills->vendor->transaction_number ?? ''}}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <br>Vendor:<br>
                                            {{$vendor_bills->vendorPo->expenditure->expenditure_name ?? ''}}<br>

                                            <br>{{$vendor_bills->vendorPo->expenditure->address ?? ''}}<br>
                                            {{$vendor_bills->vendorPo->expenditure->address2 ?? ''}}<br>
                                            {{$vendor_bills->vendorPo->expenditure->city ?? ''}}<br>
                                            {{$vendor_bills->vendorPo->expenditure->state ?? ''}}<br>
                                            {{$vendor_bills->vendorPo->expenditure->zip ?? ''}}<br>
                                            {{$vendor_bills->vendorPo->country->country_name ?? ''}}<br>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="">
                                                <span class="text-dark fw-bold">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                                {{ $vendor_bills->vendorPo->expenditure->phone ?? '' }} &nbsp;&nbsp;
                                                &nbsp;&nbsp;
                                                <span class="text-dark fw-bold">
                                                    <i class="fas fa-fax"></i>
                                                </span>
                                                {{ $vendor_bills->vendorPo->expenditure->fax ?? '' }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="">
                                                <span class="text-dark fw-bold">
                                                    Exchange Rate #:

                                                </span>
                                                {{ $vendor_bills->transaction_number ?? '' }} &nbsp;&nbsp; &nbsp;&nbsp;
                                                <span class="text-dark fw-bold">

                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="">

                                                <span class="text-dark fw-bold">
                                                    Location:
                                                </span>
                                                {{ $vendor_bills->vendorPo->location->company_name ?? '' }}
                                                <span class="text-dark fw-bold">
                                                    Invoice Date:
                                                </span>
                                                <?php
                                            $formattedDate = $vendor_bills->invoice_date ? \Carbon\Carbon::parse($vendor_bills->invoice_date)->format('d-m-Y') : ''; ?>
                                                <label for=""><span class="text-dark fw-bold">
                                                        &nbsp;</span>{{ $formattedDate ?? '' }}</label>
                                                <span class="text-dark fw-bold">
                                                    Due Date:
                                                </span>
                                                <?php
                                            $due_date = $vendor_bills->due_date ? \Carbon\Carbon::parse($vendor_bills->due_date)->format('d-m-Y') : ''; ?>
                                                <label for=""><span class="text-dark fw-bold">
                                                        &nbsp;</span>{{ $due_date ?? '' }}</label>
                                                <span class="text-dark fw-bold">
                                                    Payment Terms:
                                                </span>
                                                {{ $vendor_bills->vendorPo->payment_terms->payment_label ?? '' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Internal Notes"><span class="">Internal Notes: </span>
                                                {{ $vendor_bills->vendorPo->internal_notes ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Printed Notes"><span class="">Printed Notes: </span>
                                                {{ $vendor_bills->vendorPo->printed_notes ?? '' }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label><span class="text-dark fw-bold">Bill Summary:</span> </label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label><span class="text-dark fw-bold">Bill Total:</span></label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label><span class="text-dark fw-bold">Payment Total:</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label><span class="text-dark fw-bold">Balance Due:</span> </label>
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

        </div>
        <div class="row">
            <div class="col-12 order-0 order-md-1">
                <!-- Navigation -->
                <div class="col-12 mx-auto card-separator">
                    <div class="d-flex justify-content-between mb-3 pe-md-3">
                        <ul class="nav nav-pills flex-column flex-md-row mb-4">
                            <li class="nav-item me-3">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#po_details">
                                    <i class="bx bx-wallet me-2"></i>
                                    <span class="align-middle">Vendor Invoice Detail</span>
                                </button>
                            </li>

                            <li class="nav-item me-3">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                    <i class="bx bx-wallet me-2"></i>
                                    <span class="align-middle">Apply To Other Transaction</span>
                                </button>
                            </li>
                            <li class="nav-item me-3">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                    <i class="bx bx-wallet me-2"></i>
                                    <span class="align-middle">Files</span>
                                </button>
                            </li>
                            <li class="nav-item me-3">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                    <i class="bx bx-wallet me-2"></i>
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')

@endsection