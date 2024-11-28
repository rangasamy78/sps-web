@extends('layouts.admin')

@section('title', 'purchase')

@section('styles')
<!-- product catalog -->
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
@endsection
@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('purchases')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Purchase /</span> Home</a></h4>
        <!-- Cards with charts & info -->
        <!-- 1st row -->
        <div class="row">
            <div class="col-lg-3 col-sm-2">
                &nbsp;
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                            <div class="card-title mb-auto">
                                                <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('public/images/Po.png') }}" alt="not found" >
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('pre_purchase_requests.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Pre-Purchase Request</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('pre_purchase_requests.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-5" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add PO" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Section -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="#" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">To be Purchased</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="#" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">To be Allocated</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-12 d-flex justify-content-center">
                                <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                            <div class="card-title mb-auto">
                                                <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('public/images/freightbill.png') }}" alt="not found" >
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('vendor_pos.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Freight POs</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('vendor_pos.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-5" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Freight PO" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Section -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('freight_bills.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Freight Bills</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('freight_vendors.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Freight Vendors</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('freight_vendors.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-5" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Freight Vendor" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-12 d-flex justify-content-center">
                                <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-2">

            </div>
        </div>
        <!-- end 1st row -->
        <!-- 2nd row -->
        <div class="row mt-2">
            <div class="col-lg-3 col-sm-3">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('suppliers.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Inventory Suppliers</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('suppliers.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-5" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Supplier" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Section -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 ">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Products</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('products.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-5" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Product" style="font-size: 18px !important;"></i>
                                                    </a>
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
            <div class="col-lg-3 col-sm-3">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center w-100">
                                    <!-- Products Section with Bottom Border -->
                                    <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                        <div class="card-title mb-auto">
                                            <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('public/images/Po.png') }}" alt="not found" >
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="col-11 text-center">
                                                <a href="{{ route('purchase_orders.index') }}" class="text-decoration-none">
                                                    <h6 class="card-title mb-1 text-dark">All Pos</h6>
                                                </a>
                                            </div>
                                            <div class="col-1">
                                                <a href="{{ route('purchase_orders.create') }}" class="text-primary">
                                                    <i class="fi fi-rr-plus text-primary fs-5" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Po" style="font-size: 18px !important;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Services Section -->
                                    <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom mt-1">
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="col-11 text-center">
                                                <a href="#" class="text-decoration-none">
                                                    <h6 class="card-title mb-1 text-dark">Open Pos</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center align-items-center w-100 mt-1">
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="col-11 text-center">
                                                <a href="#" class="text-decoration-none">
                                                    <h6 class="card-title mb-1 text-dark">UnApproved POs</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mt-2">
                            <div class="col-12 d-flex justify-content-center">
                                <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-3">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                            <div class="card-title mb-auto">
                                                <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('public/images/supplierinvoice_new.png') }}" alt="not found" >
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('suppliers.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">All Supplier Invoices/Packing Lists</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('suppliers.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-5" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Supplier" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Section -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Inventory Not Received</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="row mt-2">
                            <div class="col-12 d-flex justify-content-center">
                                <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-3">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                            <div class="card-title mb-auto">
                                                <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('public/images/invetory.png') }}" alt="not found" >
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Inventory</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="row mt-2">
                            <div class="col-12 d-flex justify-content-center">
                                <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end 2nd row -->
        <!-- 3rd row -->
        <div class="row mt-4">
            <div class="col-lg-3 col-sm-3">
                &nbsp;
            </div>
            <div class="col-lg-3 col-sm-3">
                <div class="row">
                    <div class="col  d-flex justify-content-center">
                        <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-3">
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-3">
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="30px" height="25px">
                    </div>
                </div>
            </div>
        </div>
        <!-- end 3rd row -->
        <!-- 4rd row -->
        <div class="row">
            <div class="col-lg-3 col-sm-3">
                &nbsp;
            </div>
            <div class="col-lg-3 col-sm-3 mb-sm-3">
                <div class="row mt-3">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center w-100">
                                    <!-- Products Section with Bottom Border -->
                                    <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                        <div class="card-title mb-auto">
                                            <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('public/images/Po.png') }}" alt="not found" >
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="col-11 text-center">
                                                <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                    <h6 class="card-title mb-1 text-dark">Batch PO Close</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-3 mt-sm-3">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-1 border-light rounded-lg pb-1">
                                            <div class="card-title mb-auto">
                                                <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('public/images/Inven.Inventory.png') }}" alt="not found" >
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-6 text-center">
                                                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">List</h6>
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="{{ route('products.create') }}" class="text-primary">
                                                        <h6 class="card-title mb-1 text-dark">Calender</h6>
                                                    </a>
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
            <div class="col-lg-3 col-sm-3 mt-sm-3">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-light rounded-lg pb-1">
                                            <div class="card-title mb-auto">
                                                <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('public/images/inventoryreturns1.png') }}" alt="not found" >
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Inventory Returns</h6>
                                                    </a>
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
        <!-- end 3rd row -->
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @endsection
    @section('scripts')
    @endsection
