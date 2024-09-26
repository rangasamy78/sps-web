@extends('layouts.admin')

@section('title', 'Show Supplier')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Supplier /</span><span> Show Supplier</span></h4>
        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">
                                {{ $supplier->supplier_name }}
                                @if($supplier->status == 0)
                                <span class="text-danger fw-bold">(InActive)</span>
                                @endif
                            </h4>
                            <div class="d-flex align-items-center"> <!-- Container for buttons -->
                                <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                    data-id="{{ $supplier->id }}"
                                    class="btn btn-primary rounded-circle editbtn"
                                    data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Edit Supplier"
                                    style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-edit" style="font-size: 18px;"></i>
                                </a>
                                <div class='dropdown ms-2'> <!-- Add margin to separate buttons -->
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow btn-primary rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        <i class='bx bx-plus-circle icon-color' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Action"></i> <!-- Icon inside the button -->
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item showbtn text-warning' href='{{ route('suppliers.index') }}'>
                                            <i class='bx bx-list-ul'></i> List All Supplier
                                        </a>
                                        <a class='dropdown-item inactivebtn text-success' href='' data-id='{{ $supplier->id }}'>
                                            <i class='bx bx-check-circle'></i> @if($supplier->status == 0)Active Supplier
                                            @else
                                            Inactive Supplier
                                            @endif
                                        </a>

                                        <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='{{ $supplier->id }}'>
                                            <i class='bx bx-trash me-1 icon-danger'></i> Delete this Supplier
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6 col-lg-4 ">
                                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Basic Information</h5>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Print Name / DBA:</span> {{ $supplier->print_name }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Parent Location:</span> {{ $supplier->location->company_name??'' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Supplier Type:</span> {{ $supplier->supplier_type->supplier_type_name??'' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Shipment Terms:</span> {{ $supplier->shipment_term->shipment_term_name ?? '' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Payment Terms:</span> {{ $supplier->payment_term->payment_label ?? ''}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Contact Information</h5>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Contact:</span> {{ $supplier->contact_name }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Address:</span> {{ $supplier->remit_address }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Phone:</span> {{ $supplier->mobile }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Email:</span> {{ $supplier->email }}</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-2">
                                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Supplier Information</h5>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Port:</span> {{ $supplier->supplier_port->supplier_port_name??'' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Currency:</span> {{ $supplier->currency->currency_name??'' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Language:</span> {{ $supplier->language->language_name??'' }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="supplier_name"><span class="text-dark fw-bold">Supplier Since:</span> {{ $supplier->supplier_since }}</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <h5 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">Supplier Balance</h5>
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">Payable Balance:</span></label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">Credit Balance:</span></label>
                                                </div>
                                            </div>
                                            <div class="row mb-2 border-bottom">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">Unapplied Payments:</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name">$0</label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name">$0</label>
                                                </div>
                                            </div>
                                            <div class="row mb-2 border-bottom">
                                                <div class="col">
                                                    <label for="supplier_name">$0</label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="supplier_name"><span class="text-dark fw-bold">$0</span></label>
                                                </div>
                                            </div>
                                        </div>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#contact">
                                        <i class="bx bx-phone me-2"></i>
                                        <span class="align-middle">Contacts</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#account_payable">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">AP</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment">
                                        <i class="bx bx-credit-card me-2"></i>
                                        <span class="align-middle">Payments</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#price_sheet">
                                        <i class="bx bx-spreadsheet me-2"></i>
                                        <span class="align-middle">Pricesheet</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-purchase-tag me-2"></i>
                                        <span class="align-middle">POs</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-hourglass me-2"></i>
                                        <span class="align-middle">ON PO</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-right-arrow me-2"></i>
                                        <span class="align-middle">In Transit</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-history me-2"></i>
                                        <span class="align-middle">Purchase History</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-receipt me-2"></i>
                                        <span class="align-middle">Invoice & Cr.Memos</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-transfer me-2"></i>
                                        <span class="align-middle">Wiring Instr</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-folder me-2"></i>
                                        <span class="align-middle">Files</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restock">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">CRM</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- /Navigation -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- <h5 class="card-title mb-0">Inventory</h5> -->
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <!-- Options -->
                                <div class="col-12 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                        <!-- Restock Tab -->
                                        @include('supplier.contact.__contacts')
                                        <!-- Shipping Tab -->
                                        @include('supplier.account_payable.__account_payables')
                                        <!-- Global Delivery Tab -->
                                        @include('supplier.payment.__payments')
                                        <!-- Attributes Tab -->
                                        @include('supplier.price_sheet.__price_sheets')
                                        <!-- /Attributes Tab -->
                                        <!-- Advanced Tab -->
                                        <!-- /Advanced Tab -->
                                    </div>
                                </div>
                                <!-- /Options-->
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
@include('supplier.__script')
@include('supplier.contact.__script')
@include('supplier.account_payable.__script')
@include('supplier.payment.__script')
@include('supplier.price_sheet.__script')

@endsection