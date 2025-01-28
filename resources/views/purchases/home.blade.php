@extends('layouts.admin')

@section('title', 'purchase')

@section('styles')
<!-- product catalog -->
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-chubby/css/uicons-thin-chubby.css'>
@endsection
@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('purchases')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Purchase /</span> Home</a></h4>
        <div class="row">
            <div class="col">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 d-flex gap-3 flex-wrap" role="tablist">
                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#pre_purchase" aria-controls="pre_purchase" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-shopping-cart-buyer fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Pre-Purchase</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#freight" aria-controls="freight" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-forklift fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Freights</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#purchase" aria-controls="purchase" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-marketplace-alt fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Purchase Order</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#sipl" aria-controls="sipl" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-dolly-flatbed-alt fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">SIPL</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#in_transit" aria-controls="in_transit" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tc-ship fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">In Transit</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#miscellaneous" aria-controls="miscellaneous" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-inventory-alt fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Miscellaneous</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="tab-content p-0 mt-2">
                        <div class="tab-pane fade card" id="pre_purchase" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('pre_purchase_requests.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-store-buyer" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{ route('pre_purchase_requests.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Pre-Purchase Request</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('pre_purchase_requests.create') }}" class="text-decoration-none">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Pre-Purchase Request" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-cart-arrow-down" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <a href="#" class="text-primary">
                                                        <h5 class="card-title mb-0 text-dark text-center">To be Purchased</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-warehouse-alt" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <h5 class="card-title mb-0 text-dark text-center">To be Allocated</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="freight" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('vendor_pos.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-shipping-timed" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{ route('vendor_pos.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">Freight POs</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('vendor_pos.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Freight POs" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('freight_bills.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-file-invoice-dollar" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <a href="{{ route('freight_bills.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Freight Bills</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('freight_vendors.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-seller" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{ route('freight_vendors.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Freight Vendors</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{route('expenditures.create')}}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Freight Vendors" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="purchase" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('purchase_orders.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-shopping-cart-nft" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{ route('purchase_orders.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">All POs</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('purchase_orders.create') }}" class="text-decoration-none">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Purchase Order" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-cart-shopping-fast" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-12">
                                                    <a href="#" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Open POs</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('event_calendars.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-file-exclamation" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <a href="{{ route('event_calendars.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Unapproved POs</h5>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-ts-rectangle-xmark" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-12">
                                                    <a href="#" class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">Batch PO Close</h5>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="sipl" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('supplier_invoices.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-point-of-sale-bill" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{ route('supplier_invoices.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">All Supplier Invoices / Packing Lists</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('supplier_invoices.create') }}" class="text-decoration-none">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Supplier Invoices" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-do-not-enter" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <a href="#" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Inventory Not Received</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="in_transit" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <a href="#" class="text-decoration-none">
                                                    <div class="card-title mb-auto">
                                                        <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fi fi-tr-ballot" style="font-size: 50px;"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none">
                                                            <h5 class="card-title mb-0 text-dark text-center">List</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <a href="{{ route('products.create') }}" class="text-decoration-none">
                                                    <div class="card-title mb-auto">
                                                        <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fi fi-tr-daily-calendar" style="font-size: 50px;"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <div class="col">
                                                        <a href="{{ route('products.create') }}" class="text-decoration-none">
                                                            <h5 class="card-title mb-0 text-dark text-center">Calendar</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade card" id="miscellaneous" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <a href="#" class="text-decoration-none">
                                                    <div class="card-title mb-auto">
                                                        <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fi fi-tr-member-list" style="font-size: 50px;"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none">
                                                            <h5 class="card-title mb-0 text-dark text-center">Inventory</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <a href="#" class="text-decoration-none">
                                                    <div class="card-title mb-auto">
                                                        <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fi fi-tr-window-restore" style="font-size: 50px;"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none">
                                                            <h5 class="card-title mb-0 text-dark text-center">Inventory Returns</h5>
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
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @endsection
    @section('scripts')
    @include('lists.__script')
    @endsection