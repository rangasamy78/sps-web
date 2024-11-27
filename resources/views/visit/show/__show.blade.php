@extends('layouts.admin')

@section('title', 'Show Visit')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>

@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span> Show Visit</span></a></h4>
        <div class="app-ecommerce">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-header">
                            <h4 class="card-title mb-0 fw-bold">
                                <span class="text-dark fw-bold">Visit# {{$opportunity->opportunity_code}}</span><br>
                            </h4>
                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                    <div class="row p-1">
                                        <span>{{$visit_date}}</span>
                                    </div>
                                    <div class="row p-1">
                                        <span>Created from Opportunity # <span class="fw-bold text-dark">{{$opportunity->opportunity_code}}</span> by <span class="fw-bold text-dark">{{$loginPerson->first_name}} {{$loginPerson->last_name}}</span> on <span class="fw-bold text-dark">{{$opportunity_date}}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="row test-end">
                                        <!-- Box 1 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">{{$visit_count}}</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">Visit</p>
                                            </div>
                                        </div>

                                        <!-- Box 2 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">2</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">S.Order</p>
                                            </div>
                                        </div>

                                        <!-- Box 3 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">3</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">Hold</p>
                                            </div>
                                        </div>

                                        <!-- Box 4 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">4</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">Quote</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Bill To</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$customer->customer_name}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:8pt">{{$customer->address}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Job / Home Owner</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$opportunity->ship_to_job_name}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:8pt">
                                            {{$opportunity->ship_to_address}}
                                            @if($opportunity->ship_to_suite) {{$opportunity->ship_to_suite}} @endif
                                            {{$opportunity->ship_to_city}}
                                            @if($opportunity->ship_to_city && $opportunity->ship_to_state) , @endif
                                            {{$opportunity->ship_to_state}} {{$opportunity->ship_to_zip}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    @if($fabricator)
                                    <label class="form-label text-primary" style="font-size:8pt">Fabricator</label>
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$fabricator->associate_name??''}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($designer)
                                    <label class="form-label text-primary" style="font-size:8pt">Designer</label>
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$designer->associate_name??''}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($builder)
                                    <label class="form-label text-primary" style="font-size:8pt">Builder</label>
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$builder->associate_name??''}}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Primary Sales Person</label>
                                            <span class="text-dark fw-bold" style="font-size:9pt;display:block">{{$primary_sales->first_name}}&nbsp;{{$primary_sales->last_name}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Secondary Sales Person</label>
                                            <span class="text-dark fw-bold" style="font-size:9pt;display:block">{{$secondary_sales->first_name}}&nbsp;{{$secondary_sales->last_name}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">How did you hear about us?</label>
                                            <span class="text-dark fw-bold" style="font-size:9pt;display:block">{{$howDidHear->how_did_you_hear_option??''}}</span>
                                        </div>
                                    </div>
                                    <label for="survey-rating" class="form-label text-primary" style="font-size:8pt">Survey Rating:<i class="fi fi-rr-clip-mail text-primary fw-dark text-end"></i></label>
                                    <div id="survey-rating" style="font-size:7pt">
                                        <i class="fi fi-rr-star text-dark"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                        <i class="fi fi-rr-star text-dark fw-bold"></i>
                                    </div>
                                    <div class="row">
                                        <div class="col showContact">
                                            <span class="text-dark fw-bold"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label">Probability</label>
                                            <select type="select" class="form-select">
                                                <option value="0">0%</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label">Stage</label>
                                            <select type="select" class="form-select">
                                                <option value="0">0%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Printed Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$visit->visit_printed_notes}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$opportunity->internal_notes}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Special Instructions</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="special_notes_input">{{$opportunity->special_instructions}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tabs -->
            <div class="row mt-3">
                <div class="col-12 order-0 order-md-1">
                    <!-- Navigation -->
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#VisitProduct">
                                        <i class='bx bxl-product-hunt me-2'></i>
                                        <span class="align-middle">Products</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#file">
                                        <i class="bx bx-folder me-2"></i>
                                        <span class="align-middle">Files</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#CRMEvent">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">CRM</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#BillToContact">
                                        <i class="bx bx-phone me-2"></i>
                                        <span class="align-middle">Contacts</span>
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
                                        @include('visit.product.products')
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
</div>
<!-- / Content -->
<div class="content-backdrop fade"></div>
</div>
@endsection
@section('scripts')
@include('visit.product.__script')
@endsection