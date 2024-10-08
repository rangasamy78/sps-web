@extends('layouts.admin')
@section('title', 'Show Product')
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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Product /</span><span> Show Services</span></h4>
            <div class="app-ecommerce">
                <div class="row">
                    <!-- first column -->
                    {{-- {{ $product_groups }} --}}
                    {{-- {{ $unit_measures->unit_measure_name }} --}}
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4><span class="card-title mb-0 fw-bold">{{ $service->service_name ?? '' }}</span><span
                                        style="font-size: 14px">
                                        @if (!empty($service->service_sku))
                                            ({{ $service->service_sku ?? '' }})
                                        @endif
                                    </span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label><span class="text-dark fw-bold">Service Type: </span>
                                                    {{ $service_types->service_type ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label><span class="text-dark fw-bold">Service Group: </span>
                                                    {{ $product_groups->product_group_name ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label><span class="text-dark fw-bold">Service Category: </span>
                                                    {{ $service_categories->service_category ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="GLIncome_sccount"><span class="text-dark fw-bold">GLIncome
                                                        Account: </span> {{ $gl_sales_accounts->account_code ?? '' }} -
                                                    {{ $gl_sales_accounts->account_name ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="Thickness"><span class="text-dark fw-bold">GLExpense Account:
                                                    </span> {{ $gl_cost_of_sales_accounts->account_code ?? '' }} -
                                                    {{ $gl_cost_of_sales_accounts->account_name ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="Thickness"><span class="text-dark fw-bold">Preferred Expenditure:
                                                    </span> {{ $service_expenditures->expenditure_name ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="Thickness"><span class="text-dark fw-bold">Avg. Est Cost:
                                                    </span> {{ $service->avg_est_cost ?? '' }}</label>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <h5
                                            style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">
                                            Selling Prices for this Service:
                                        </h5>

                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="primary_phone"><span class="text-dark fw-bold">Homeowner Price -
                                                        Loose Slab Price:</span>
                                                    {{ $service->service_price->homeowner_price ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="secondary_phone"><span class="text-dark fw-bold">Bundle Price -
                                                        Bundle Price:</span>
                                                    {{ $service->service_price->bundle_price ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="mobile"><span class="text-dark fw-bold">Special Price -
                                                        Special Price:</span>
                                                    {{ $service->service_price->special_price ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Loose Slab Price Per
                                                        SQFT - Price4:</span>
                                                    {{ $service->service_price->loose_slab_price ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="mobile"><span class="text-dark fw-bold">Bundle Price Per SQFT
                                                        - Price5:</span>
                                                    {{ $service->service_price->bundle_price_sqft ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Special Price Per SQFT
                                                        - Price6:</span>
                                                    {{ $service->service_price->special_price_per_sqft ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Owner Approval Price
                                                        Per SQFT - Price7:</span>
                                                    {{ $service->service_price->owner_approval_price ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Loose Slab Price Per
                                                        Slab - Price8:</span>
                                                    {{ $service->service_price->loose_slab_per_slab ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Bundle Price Per Slab
                                                        - Price9:</span>
                                                    {{ $service->service_price->bundle_price_per_slab ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Special Price Per Slab
                                                        - Price10:</span>
                                                    {{ $service->service_price->special_price_per_slab ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Owner Approval Price
                                                        Per Slab - Price11:</span>
                                                    {{ $service->service_price->owner_approval_price_per_slab ?? '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="website"><span class="text-dark fw-bold">Price12 -
                                                        Price12:</span>
                                                    {{ $service->service_price->price12 ?? '' }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <h5
                                            style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;">
                                            Packaging Detail
                                        </h5>

                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="primary_phone"><span class="text-dark fw-bold">UOM:</span>
                                                    {{ $unit_measures->unit_measure_name ?? '' }}</label>
                                            </div>
                                        </div>
                                        <h5
                                            style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 2px;" class="mt-4">
                                            Usage:
                                        </h5>
                                        <div class="row mb-2">
                                            @if (!empty($service->frequent_in_so))
                                                <div class="col-2">
                                                    <div class="avatar me-sm-4">
                                                        <span class="avatar-initial rounded bg-label-secondary">
                                                            <i class="bx bx-dollar bx-m"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col mt-2"><span>Frequently used</span></div>
                                            @endif
                                        </div>
                                        <div class="row mb-2">
                                            @if (!empty($service->frequent_in_customer_cm))
                                                <div class="col-2">
                                                    <div class="avatar me-sm-4">
                                                        <span class="avatar-initial rounded bg-label-secondary">
                                                            <i class="bx bxs-user bx-m"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col mt-2"><span>Frequently used</span></div>
                                            @endif
                                        </div>
                                        <div class="row mb-2">
                                            @if (!empty($service->frequent_in_po))
                                                <div class="col-2">
                                                    <div class="avatar me-sm-4">
                                                        <span class="avatar-initial rounded bg-label-secondary">
                                                            <i class="bx bx-repeat bx-m"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col mt-2"><span>Frequently used</span></div>
                                            @endif
                                        </div>
                                        <div class="row mb-2">
                                            @if (!empty($service->frequent_in_supplier_cm))
                                                <div class="col-2">
                                                    <div class="avatar me-sm-4">
                                                        <span class="avatar-initial rounded bg-label-secondary">
                                                            <i class="bx bxs-user-detail bx-m"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col mt-2"><span>Frequently used</span></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4">Notes
                                            <textarea class="form-control" style="background: lightgoldenrodyellow;" readonly >{{ $service->notes ?? '' }}</textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3">Special Instructions
                                            <textarea class="form-control"  style="background: lightgoldenrodyellow;" readonly>{{ $service->internal_instruction ?? '' }}</textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3">Disclaimer
                                            <textarea class="form-control"  style="background: lightgoldenrodyellow;" readonly>{{ $service->disclaimer ?? '' }}</textarea>
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
                                            data-bs-target="#vendor_pricing">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">Vendor Pricing</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#special_pricing">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">Special Pricing</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quotes">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">Quotes</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sos">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">SOs</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sample_orders">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">Invoices</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pos">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">POs</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#supplkier_invoices_bills">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">Supplier Invoices / Bills</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">Files</span>
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

                        <!-- /Navigation -->
                        <div class="card mb-4">
                            <div class="card-header">

                            </div>
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
        <!-- / Content -->
        <div class="content-backdrop fade"></div>

    </div>

@endsection
@section('scripts')
    @include('service.__scripts')
@endsection
