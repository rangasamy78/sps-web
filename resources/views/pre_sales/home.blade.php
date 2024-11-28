@extends('layouts.admin')

@section('title', 'pre sales')

@section('styles')
<!-- product catalog -->
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
@endsection
@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('pre_sales')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Pre Sales /</span> Home</a></h4>
        <!-- Cards with charts & info -->
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('public/images/associate.png') }}" alt="Not Found" >
                                            </span>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center w-100">
                                            <div class="col-11">
                                                <a href="{{ route('associates.index') }}" class="text-decoration-none">
                                                    <h6 class="card-title mb-1 text-dark text-center">Associates</h6>
                                                </a>
                                            </div>
                                            <div class="col-1">
                                                <a href="{{ route('associates.create') }}" class="text-primary">
                                                    <i class="fi fi-rr-plus text-primary ps-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Associate" style="font-size: 18px !important;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-10 mt-4">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <div class="card-title mb-auto">
                                            <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('public/images/product.png') }}" alt="not found" >
                                            </span>
                                        </div>

                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-dark rounded-lg pb-3">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Products</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('products.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Product" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Section -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('services.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Services</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('services.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Service" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-2 mt-5">
                        <div class="row mt-5">
                            <div class="col-12">
                                <img src="{{ asset('public/images/r-arrow.png') }}" alt="Not Found" width="40px" height="30px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row ms-5">
                    <div class="col-10">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <div class="card-title mb-auto">
                                            <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('public/images/customer.png') }}" alt="not found" >
                                            </span>
                                        </div>

                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-dark rounded-lg pb-3">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('customers.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Customers</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('customers.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Product" style="font-size: 18px !important;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Section -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-11 text-center">
                                                    <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Contacts</h6>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('products.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Service" style="font-size: 18px !important;"></i>
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
                <div class="row ms-5 mt-2">
                    <div class="col-10 d-flex justify-content-center">
                        <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="40px" height="30px">
                    </div>
                </div>
                <div class="row ms-5 mt-2">
                    <div class="col-10">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Image column -->
                                    <div class="col-lg-6 col-sm-5 col-md-6 p-0">
                                        <img src="{{ asset('public/images/open-door.png') }}" alt="Not Found">
                                        <div class="d-flex align-items-center border-dark mt-2 border-top border-light rounded-lg">
                                            <a href="{{ route('opportunities.index') }}" class="text-decoration-none flex-grow-1 mt-1">
                                                <h6 class="card-title mb-0 text-dark text-center">Opportunities</h6>
                                            </a>
                                            <a href="{{ route('opportunities.create') }}" class="text-primary ms-1 mt-1">
                                                <i class="fi fi-rr-plus" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Opportunity" style="font-size: 18px !important;"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Content column with borders -->
                                    <div class="col-lg-6 col-sm-7 col-md-6">
                                        <div class="d-flex flex-column h-100">
                                            <!-- First item (Icon + Label) -->
                                            <div class="d-flex align-items-center border-dark mb-2 p-2 border-bottom border-top">
                                                <a href="javascript:void(0)" class="text-primary me-3">
                                                    <i class="fi fi-rr-plus fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Visit" style="font-size: 18px !important;"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="text-decoration-none flex-grow-1">
                                                    <h6 class="card-title mb-0 text-dark text-center">Visits</h6>
                                                </a>
                                            </div>

                                            <!-- Second item (Icon + Label) -->
                                            <div class="d-flex align-items-center border-dark mb-2 p-2 border-bottom">
                                                <a href="javascript:void(0)" class="text-primary me-3">
                                                    <i class="fi fi-rr-plus fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Sample Order" style="font-size: 18px !important;"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="text-decoration-none flex-grow-1">
                                                    <h6 class="card-title mb-0 text-dark text-center">Sample Orders</h6>
                                                </a>
                                            </div>

                                            <!-- Third item (Icon + Label) -->
                                            <div class="d-flex align-items-center border-dark mb-2 p-2 border-bottom">
                                                <a href="javascript:void(0)" class="text-primary me-3">
                                                    <i class="fi fi-rr-plus fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Quotes" style="font-size: 18px !important;"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="text-decoration-none flex-grow-1">
                                                    <h6 class="card-title mb-0 text-dark text-center">Quotes</h6>
                                                </a>
                                            </div>

                                            <!-- Fourth item (Icon + Label) -->
                                            <div class="d-flex align-items-center border-dark mb-2 p-2 border-bottom">
                                                <a href="javascript:void(0)" class="text-primary me-3">
                                                    <i class="fi fi-rr-plus fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Hold" style="font-size: 18px !important;"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="text-decoration-none flex-grow-1">
                                                    <h6 class="card-title mb-0 text-dark text-center">Holds</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-2 mt-5">
                        <div class="row ms-5 mt-2">
                            <div class="col d-flex justify-content-center">
                                <img src="{{ asset('public/images/r-arrow.png') }}" alt="Not Found" width="40px" height="30px">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row ms-5 mt-2">
                    <div class="col-10 d-flex justify-content-center">
                        <img src="{{ asset('public/images/d-arrow.png') }}" alt="Not Found" width="40px" height="30px">
                    </div>
                </div>
                <div class="row ms-5 mt-2">
                    <div class="col-lg-10">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('public/images/sale.png') }}" alt="Not Found" >
                                            </span>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center w-100">
                                            <div class="col-11">
                                                <a href="javascript:void(0)" class="text-decoration-none">
                                                    <h6 class="card-title mb-1 text-dark text-center">Sale Orders</h6>
                                                </a>
                                            </div>
                                            <div class="col-1">
                                                <a href="javascript:void(0)" class="text-primary">
                                                    <i class="fi fi-rr-plus text-primary ps-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Sale Order" style="font-size: 18px !important;"></i>
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
            <div class="col-lg-3 mt-5">
                <div class="row mt-5"></div>
                <div class="row mt-5">
                    <div class="col-9 ms-5 mt-5">
                        <div class="card card-border-shadow-primary mt-5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <img src="{{ asset('public/images/calendar.png') }}" alt="Not Found" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex align-items-center border-dark mb-1 p-1 border-bottom">
                                        <a href="{{ route('visit_calendars.index') }}" class="text-decoration-none flex-grow-1 ps-4">
                                            <h6 class="card-title mb-0 text-dark text-center">Visit Calendar</h6>
                                        </a>
                                        <a href="#" class="text-primary">
                                            <i class="fi fi-rr-plus fs-4" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Calendar" style="font-size: 18px !important;"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex align-items-center border-dark mb-1 p-1 border-bottom">
                                        <a href="{{ route('my_events.index') }}" class="text-decoration-none flex-grow-1 ps-4">
                                            <h6 class="card-title mb-0 text-dark text-center">My Events</h6>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex align-items-center border-dark mb-1 p-1 border-bottom">
                                        <a href="{{ route('event_calendars.index') }}" class="text-decoration-none flex-grow-1 ps-4">
                                            <h6 class="card-title mb-0 text-dark text-center">My Event Calendar</h6>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex align-items-center border-dark mb-1 p-1 border-bottom">
                                        <a href="{{ route('quote_stages_dashboard.index') }}" class="text-decoration-none flex-grow-1 ps-4">
                                            <h6 class="card-title mb-0 text-dark text-center">Quote Follow-Up:Stage</h6>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex align-items-center border-dark mb-1 p-1 border-bottom">
                                        <a href="{{ route('follow_ups.index') }}" class="text-decoration-none flex-grow-1 ps-4">
                                            <h6 class="card-title mb-0 text-dark text-center">Follow-Up:%</h6>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex align-items-center border-dark mb-1 p-1 border-bottom">
                                        <a href="#" class="text-decoration-none flex-grow-1 ps-4">
                                            <h6 class="card-title mb-0 text-dark text-center">Batch Quote Close</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-9 ms-5">
                        <div class="card card-border-shadow-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column align-items-center w-100">
                                        <div class="card-title mb-auto">
                                            <span class="p-1 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('public/images/dashboard.png') }}" alt="not found" >
                                            </span>
                                        </div>

                                        <!-- Products Section with Bottom Border -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 border-bottom border-1 border-dark rounded-lg pb-2">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-12 text-center">
                                                    <a href="javascript:void(0)" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Avg Opportunity Size</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Section -->
                                        <div class="d-flex flex-column justify-content-center align-items-center w-100 mt-1">
                                            <div class="d-flex justify-content-between w-100">
                                                <div class="col-12 text-center">
                                                    <a href="javascript:void(0)" class="text-decoration-none">
                                                        <h6 class="card-title mb-1 text-dark">Sales Pipeline</h6>
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
        <!--/ items -->

    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@endsection
