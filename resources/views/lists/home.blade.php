@extends('layouts.admin')

@section('title', 'lists')

@section('styles')
<!-- product catalog -->
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
@endsection
@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('lists')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Lists /</span> Home</a></h4>
        <!-- Cards with charts & info -->
        <div class="row">
            <h4 class="fw-bold pe-2 mb-1 text-dark">Items</h4>
            <div class="col-lg-2 mb-4">
                <div class="card card-border-shadow-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex flex-column align-items-center">
                                <div class="card-title mb-auto">
                                    <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fi fi-tr-catalog" style="font-size: 50px;"></i>
                                    </span>
                                </div>
                                <div class="text-center mt-2">
                                    <h5 class="card-title mb-2 text-dark">Product Catalog</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="card card-border-shadow-primary">
                    <div class="card-body row g-4">
                        <div class="col-md-3 pe-md-4 card-separator">
                            <div class="d-flex justify-content-center">
                                <div class="d-flex flex-column align-items-center">
                                    <a href="{{route('products.index')}}" class="text-decoration-none">
                                        <div class="card-title mb-auto">
                                            <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-boxes" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                    </a>
                                    <div class="d-flex justify-content-center align-items-center mt-2">
                                        <div class="col-11">
                                            <a href="{{route('products.index')}}" class="text-decoration-none">
                                                <h5 class="card-title mb-1 text-dark text-center">Product</h5>
                                            </a>
                                        </div>
                                        <div class="col-1">
                                            <a href="{{route('products.create')}}" class="text-primary">
                                                <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Product" style="font-size: 25px;"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pe-md-4 card-separator">
                            <div class="d-flex justify-content-center">
                                <a href="{{route('products.stock')}}" class="text-primary">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-supplier-alt" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h5 class="card-title mb-1 text-dark">Stock</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 pe-md-4 card-separator">
                            <a href="{{route('products.price_list_product')}}" class="text-primary">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-tags" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h5 class="card-title mb-1 text-dark">Price List</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 ps-md-4">
                            <a href="{{route('products.customer_price_list_product')}}" class="text-primary">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-hand-holding-usd" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h5 class="card-title mb-1 text-dark">Customer Price List</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <div class="card card-border-shadow-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex flex-column align-items-center">
                                <a href="{{route('services.index')}}" class="text-decoration-none">
                                    <div class="card-title mb-auto">
                                        <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fi fi-tr-person-dolly-empty" style="font-size: 50px;"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="d-flex justify-content-center align-items-center mt-2">
                                    <div class="col-11">
                                        <a href="{{route('services.index')}}" class="text-decoration-none">
                                            <h5 class="card-title mb-1 text-dark text-center">Services</h5>
                                        </a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{route('services.create')}}" class="text-primary">
                                            <i class="fi fi-rr-plus text-primary ps-1" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Service" style="font-size: 25px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ items -->
        <!-- parties -->
        <div class="row">
            <h4 class="fw-bold pe-2 mb-1  text-dark">Parties</h4>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex flex-column align-items-center">
                                <a href="{{route('customers.index')}}" class="text-decoration-none">
                                    <div class="card-title mb-auto">
                                        <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fi fi-ts-customer-care" style="font-size: 50px;"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="d-flex justify-content-center align-items-center mt-2">
                                    <div class="col-11">
                                        <h5 class="card-title mb-0 text-dark text-center">Customers</h5>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{route('customers.create')}}" class="text-primary">
                                            <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Customer" style="font-size: 25px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex flex-column align-items-center">
                                <a href="{{route('suppliers.index')}}" class="text-decoration-none">
                                    <div class="card-title mb-auto">
                                        <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fi fi-ts-supplier" style="font-size: 50px;"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="d-flex justify-content-center align-items-center mt-2">
                                    <div class="col-11">
                                        <h5 class="card-title mb-0 text-dark text-center">
                                            <a href="{{route('suppliers.index')}}" class="text-dark text-decoration-none">Suppliers</a>
                                        </h5>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{route('suppliers.create')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Supplier">
                                            <i class="fi fi-rr-plus ps-3" style="font-size: 25px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex flex-column align-items-center">
                                <a href="{{route('expenditures.index')}}" class="text-decoration-none">
                                    <div class="card-title mb-auto">
                                        <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fi fi-tr-seller" style="font-size: 50px;"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="d-flex justify-content-center align-items-center mt-2">
                                    <div class="col-11">
                                        <a href="{{route('expenditures.index')}}" class="text-decoration-none">
                                            <h5 class="card-title mb-0 text-dark text-center">Expenditures</h5>
                                        </a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{route('expenditures.create')}}" class="text-decoration-none">
                                            <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Expenditure" style="font-size: 25px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <a href="{{route('associates.index')}}" class="text-decoration-none">
                                <div class="card-title mb-auto">
                                    <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fi fi-tr-users-alt" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Supplier" style="font-size: 50px;"></i>
                                    </span>
                                </div>
                            </a>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <a href="{{route('associates.index')}}" class="text-decoration-none">
                                        <h5 class="card-title mb-0 text-dark text-center">Associates</h5>
                                    </a>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('associates.create')}}" class="text-decoration-none">
                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Associate" style="font-size: 25px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ parties-->
        <!-- company -->
        <div class="row">
            <h4 class="fw-bold pe-2 mb-1  text-dark">Company</h4>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <div class="card-title mb-auto">
                                <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fi fi-tr-warehouse-alt" style="font-size: 50px;"></i>
                                </span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <h5 class="card-title mb-0 text-dark text-center">Locations</h5>
                                </div>
                                <div class="col-1">
                                    <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Location" style="font-size: 25px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <div class="card-title mb-auto">
                                <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fi fi-tr-employees-woman-man" style="font-size: 50px;"></i>
                                </span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <h5 class="card-title mb-0 text-dark text-center">Employees</h5>
                                </div>
                                <div class="col-1">
                                    <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Employee" style="font-size: 25px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <div class="card-title mb-auto">
                                <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fi fi-ts-convert-shapes" style="font-size: 50px;"></i>
                                </span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <h5 class="card-title mb-0 text-dark text-center">Resources</h5>
                                </div>
                                <div class="col-1">
                                    <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Resource" style="font-size: 25px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <a href="{{route('consignments.index')}}" class="text-decoration-none">
                                <div class="card-title mb-auto">
                                    <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fi fi-ts-shelves" style="font-size: 50px;"></i>
                                    </span>
                                </div>
                            </a>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <a href="{{route('consignments.index')}}" class="text-decoration-none">
                                        <h5 class="card-title mb-0 text-dark text-center">Consignment</h5>
                                    </a>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('consignments.create')}}" class="text-decoration-none">
                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Consignment" style="font-size: 25px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end company -->
        <!-- accounting -->
        <div class="row">
            <h4 class="fw-bold pe-2 mb-1  text-dark">Accounting</h4>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <a href="{{route('accounts.index')}}" class="text-decoration-none">
                                <div class="card-title mb-auto">
                                    <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fi fi-ts-file-invoice-dollar" style="font-size: 50px;"></i>
                                    </span>
                                </div>
                            </a>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <a href="{{route('accounts.index')}}" class="text-decoration-none">
                                        <h5 class="card-title mb-0 text-dark text-center">Chart of Accounts</h5>
                                    </a>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('accounts.create')}}" class="text-decoration-none">
                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Chart of Account" style="font-size: 25px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <a href="{{route('tax_codes.index')}}" class="text-decoration-none">
                                <div class="card-title mb-auto">
                                    <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fi fi-ts-tax-alt" style="font-size: 50px;"></i>
                                    </span>
                                </div>
                            </a>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <a href="{{route('tax_codes.index')}}" class="text-decoration-none">
                                        <h5 class="card-title mb-0 text-dark text-center">Tax Codes</h5>
                                    </a>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('tax_codes.create')}}" class="text-decoration-none">
                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Tax Code" style="font-size: 25px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <a href="{{route('tax_authorities.index')}}" class="text-decoration-none">
                                <div class="card-title mb-auto">
                                    <span class="rounded bg-label-dark p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fi fi-ts-money-check-edit" style="font-size: 50px;"></i>
                                    </span>
                                </div>
                            </a>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <div class="col-11">
                                    <a href="{{route('tax_authorities.index')}}" class="text-decoration-none">
                                        <h5 class="card-title mb-0 text-dark text-center">Tax Authorities</h5>
                                    </a>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('tax_authorities.create')}}" class="text-decoration-none">
                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Tax Authorities" style="font-size: 25px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end accounting -->
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@endsection