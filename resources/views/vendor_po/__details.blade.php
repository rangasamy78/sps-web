@extends('layouts.admin')
@section('title', 'Show Vendor PO')
@section('styles')
<style>
.product-link {
    color: black;
    text-decoration: none;
}

.associate-link:hover {
    text-decoration: underline;
}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Vendor PO /</span><span> Vendor Detail</span></h4>
        <div class="app-ecommerce">
            <div class="row">

                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">

                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Vendor PO">
                                                <span class="text-dark fw-bold">
                                                    <h2>{{ $vendor_po->vendor->expenditure_name ?? '' }}</h2>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Vendor PO"><span class="text-dark fw-bold">Print on Check As /
                                                    DBA</span></label>
                                            {{ $vendor_po->vendor->print_name ?? '' }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="Vendor PO"><span class="text-dark fw-bold">Vendor
                                                    Since:</span></label>
                                            <?php
                                            $formattedDate = $vendor_po->since_date ? \Carbon\Carbon::parse($vendor_po->since_date)->format('d-m-Y') : ''; ?>
                                            <label><span
                                                    class="text-dark fw-bold">&nbsp;</span>{{ $formattedDate ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label for="Vendor Details"><span
                                                                class="text-dark fw-bold">Contact Details:
                                                            </span></label>
                                                        <br>Contact:
                                                        {{ $vendor_po->vendor->expenditure_name ?? '' }}<br>
                                                        A: {{ $vendor_po->address ?? '' }}<br>
                                                        {{ $vendor_po->address2 ?? '' }} <br>
                                                        {{ $vendor_po->city ?? '' }} <br>
                                                        {{ $vendor_po->state ?? '' }} <br>
                                                        {{ $vendor_po->zip ?? ''}} <br>
                                                        {{ $vendor_po->country->country_name ?? '' }} <br>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">P:
                                                        {{ $vendor_po->vendor->primary_phone ?? ''}}<br>{{ $vendor_po->vendor->secondary_phone ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">F: {{ $vendor_po->vendor->fax ?? ''}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">M: {{ $vendor_po->vendor->mobile ?? ''}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">E: {{ $vendor_po->vendor->email ?? '' }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">W: {{ $vendor_po->vendor->website ?? '' }}</div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label for="Vendor Details"><span
                                                                class="text-dark fw-bold">Accounting
                                                                Info:</span></label>
                                                        <br>Currency: {{ $vendor_po->vendor->currency ?? ''}}
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

                                <div class="col-12 mx-auto card-separator">
                                    <div class="d-flex justify-content-between mb-3 pe-md-3">
                                        <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                            <li class="nav-item me-3">
                                                <button class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#inventory">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">Contacts</span>
                                                </button>
                                            </li>

                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">AP</span>
                                                </button>
                                            </li>
                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">Payments</span>
                                                </button>
                                            </li>
                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">Bills</span>
                                                </button>
                                            </li>
                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">Vendor POs</span>
                                                </button>
                                            </li>
                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">Pricesheet</span>
                                                </button>
                                            </li>
                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">Files()</span>
                                                </button>
                                            </li>
                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">Wiring Instr</span>
                                                </button>
                                            </li>
                                            <li class="nav-item me-3">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#crm">
                                                    <i class="bx bx-wallet me-2"></i>
                                                    <span class="align-middle">CRM</span>
                                                </button>
                                            </li>
                                        </ul>
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
            @include('vendor_po.__scripts')
            @include('vendor_po.bills.__scripts')
            @endsection