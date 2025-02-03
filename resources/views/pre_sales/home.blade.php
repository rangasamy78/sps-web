@extends('layouts.admin')

@section('title', 'pre sales')

@section('styles')
<!-- product catalog -->
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
@endsection
@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><a href="{{route('pre_sales')}}" class="text-decoration-none text-dark"><span class="text-muted fw-light">Pre Sales /</span> Home</a></h4>
        <div class="row">
            <div class="col">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 d-flex gap-3 flex-wrap" role="tablist">
                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#contacts" aria-controls="items" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-address-book fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Contacts</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#opportunities" aria-controls="parties" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-garage-open fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Opportunities</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#calendar" aria-controls="company" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-calendar-clock fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Calendar</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#sales" aria-controls="sales" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-benefit-porcent fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Sales</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item flex-fill cursor-pointer">
                            <div class="card h-100 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#report" aria-controls="report" aria-selected="false">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="card-title mb-auto">
                                            <span class="rounded p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fi fi-tr-holding-hand-revenue fw-bold text-dark" style="font-size: 50px;"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0 text-dark text-center">Report</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="tab-content p-0 mt-2">
                        <div class="tab-pane fade card" id="contacts" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{route('associates.index')}}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-users-alt" style="font-size: 50px;"></i>
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
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{route('customers.index')}}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
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
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-customer-service" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <h5 class="card-title mb-0 text-dark text-center">Contact</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{route('products.index')}}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-boxes" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{route('products.index')}}" class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">All Products</h5>
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
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{route('services.index')}}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
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
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Service" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="opportunities" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('opportunities.index') }}?tab=opportunities" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-discussion-idea" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{ route('opportunities.index') }}?tab=opportunities " class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">Opportunity</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('opportunities.create') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Opportunity" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('opportunities.index') }}?tab=visits" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-visit" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{ route('opportunities.index') }}?tab=visits" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Visits</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('visit.opportunities.index') }}" class="text-decoration-none">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Visit + Opportunity" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{route('opportunities.index')}}?tab=samples" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-order-history" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{route('opportunities.index')}}?tab=samples" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Sample Order</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{route('create.index')}}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Sample Order + Opportunity" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{route('opportunities.index')}}?tab=quotes" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-catalog" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <a href="{{route('opportunities.index')}}?tab=quotes" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Quotes</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('quote.index') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Quote + Opportunity" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{route('opportunities.index')}}?tab=holds" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-mobile-hand" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{route('opportunities.index')}}?tab=holds" class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">Holds</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{ route('hold.index') }}" class="text-primary">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Hold + Opportunity" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="calendar" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('visit_calendars.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-calendar" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="#" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Visit Calender</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="#" class="text-decoration-none">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Visit Calender" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('my_events.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-calendar-image" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-12">
                                                    <a href="{{ route('my_events.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">My Event</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('event_calendars.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-calendar-week" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col">
                                                    <a href="{{ route('event_calendars.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">My Event Calendar</h5>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('quote_stages_dashboard.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-subscription-user" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-12">
                                                    <a href="{{ route('quote_stages_dashboard.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">Quote Follow-Up:Stage</h5>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="{{ route('follow_ups.index') }}" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-mortgage" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-12">
                                                    <a href="{{ route('follow_ups.index') }}" class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">Follow-Up %</h5>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-school-lock" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-12">
                                                    <a href="#" class="text-decoration-none">
                                                        <h5 class="card-title mb-1 text-dark text-center">Batch Quote Close</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="sales" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="text-decoration-none">
                                                <div class="card-title mb-auto">
                                                    <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fi fi-tr-point-of-sale-bill" style="font-size: 50px;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-center align-items-center mt-2">
                                                <div class="col-11">
                                                    <a href="{{route('associates.index')}}" class="text-decoration-none">
                                                        <h5 class="card-title mb-0 text-dark text-center">Sales Order</h5>
                                                    </a>
                                                </div>
                                                <div class="col-1">
                                                    <a href="{{route('associates.create')}}" class="text-decoration-none">
                                                        <i class="fi fi-rr-plus text-primary ps-3" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Add Sales Order" style="font-size: 25px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade card" id="report" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <a href="#" class="text-decoration-none">
                                                    <div class="card-title mb-auto">
                                                        <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fi fi-tr-chart-histogram" style="font-size: 50px;"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none">
                                                            <h5 class="card-title mb-0 text-dark text-center">Avg Opportunity Size</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="d-flex flex-column align-items-center">
                                                <a href="" class="text-decoration-none">
                                                    <div class="card-title mb-auto">
                                                        <span class="rounded  p-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fi fi-tr-chart-simple" style="font-size: 50px;"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none">
                                                            <h5 class="card-title mb-0 text-dark text-center">Sales Pipeline</h5>
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
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@include('lists.__script')
@endsection