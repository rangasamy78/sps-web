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
                            <div class="row mb-2">
                                <div class="col-6">
                                    <h4 class="card-title mb-0 fw-bold">
                                        <span class="text-dark fw-bold">Visit# {{$opportunity->opportunity_code}} - {{$position}}</span><br>
                                    </h4>
                                </div>
                                <div class="col">
                                    <div class="d-flex justify-content-end"> <!-- Container for buttons -->
                                        <a href="{{ route('visit.opportunities.edit', $visit->id) }}"
                                            data-id="{{ $visit->id }}"
                                            class="btn editbtn text-dark fw-bold"
                                            data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Update Visit"
                                            style="width: 25px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fi fi-rr-pen-circle fs-2"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            data-id="{{ $visit->id }}"
                                            class="btn text-dark fw-bold rounded-circle deletebtn ms-2"
                                            data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Delete Visit"
                                            style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fi fi-rr-cross-circle fs-2" style="font-size: 18px;"></i>
                                        </a>
                                        <div class='dropdown ms-2'> <!-- Add margin to separate buttons -->
                                            <button type='button' class='btn p-0 dropdown-toggle hide-arrow text-dark fw-bold rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                <i class='fi fi-rr-circle-ellipsis fs-2' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="More"></i> <!-- Icon inside the button -->
                                            </button>
                                            <div class='dropdown-menu'>
                                                <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('opportunities.index') }}'>
                                                    <i class='bx bx-list-ul'></i> List All Visit
                                                </a>
                                                <a class='dropdown-item deletebtn fw-bold text-dark' href='javascript:void(0);' data-id='{{ $visit->id }}'>
                                                    <i class='bx bx-trash me-1 icon-danger'></i> Delete Visit
                                                </a>
                                                <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                                    <i class='bx bx-duplicate'></i> View Log
                                                </a>
                                                <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                                    <i class='bx bxs-user-detail'></i></i> Backend Details
                                                </a>
                                                <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                                    <i class='bx bx-purchase-tag-alt'></i> View Map
                                                </a>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
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
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:9pt">{{$fabricator->associate_name??''}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($designer)
                                    <label class="form-label text-primary" style="font-size:8pt">Designer</label>
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:9pt">{{$designer->associate_name??''}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($builder)
                                    <label class="form-label text-primary" style="font-size:8pt">Builder</label>
                                    <div class=" row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:9pt">{{$builder->associate_name??''}}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    @if ($primary_sales->first_name)
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Primary Sales Person</label>
                                            <span class="text-dark fw-bold" style="font-size:9pt;display:block">{{$primary_sales->first_name}}&nbsp;{{$primary_sales->last_name}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($secondary_sales->first_name)
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Secondary Sales Person</label>
                                            <span class="text-dark fw-bold" style="font-size:9pt;display:block">{{$secondary_sales->first_name}}&nbsp;{{$secondary_sales->last_name}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if (!empty($contacts))
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Contact</label>
                                            <div class="col showContact">
                                                @foreach ($contacts as $contact)
                                                <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_{{ $contact['visit_contact_id'] }}">
                                                    <span class="fw-semibold">{{ $contact['name'] }}</span>
                                                    <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="{{ $contact['visit_contact_id'] }}">
                                                        <i class="fas fa-trash-alt fa-xs"></i> <!-- Apply the size class here -->
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($howDidHear->how_did_you_hear_option)
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">How did you hear about us?</label>
                                            <span class="text-dark fw-bold" style="font-size:9pt;display:block">{{$howDidHear->how_did_you_hear_option??''}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    <label for="survey-rating" class="form-label text-primary" style="font-size:8pt">Survey Rating:<i class="fi fi-rr-clip-mail text-primary fw-dark text-end"></i></label>
                                    <div id="survey-rating" style="font-size:7pt" data-bs-toggle="modal" data-bs-target="#surveyRateModel">
                                        @for ($i=0;$i<=8;$i++)
                                            <i class="fi fi-rr-star text-dark fw-bold"></i>
                                            @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label text-dark fw-bold">Probability</label>
                                            <select class="form-control" id="probability_close_id" name="probability_close_id">
                                                <option value="" disabled selected>--select--</option>
                                                @foreach($data['probabilityCloses'] as $id => $probability_close)
                                                <option value="{{ $id }}" {{ $visit->probability_close_id == $id ? 'selected' : '' }}>
                                                    Probability - {{ $probability_close }}%
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label class="form-label text-dark text-dark fw-bold">Stage</label>
                                            <select type="select" class="form-select" id="opportunity_stage_id" name="opportunity_stage_id">
                                                <option value="" disabled selected>--select--</option>
                                                @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                                <option value="{{ $id }}" {{ $opportunity->opportunity_stage_id == $id ? 'selected' : '' }}>{{ $opportunity_stage}}</option>
                                                @endforeach
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
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Contact">
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
                                        @include('visit.file.files')
                                        @include('visit.crm_event.crm_events')
                                        @include('visit.contact.contacts')
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
@include('visit.show.__model')
<!-- / Content -->
<div class="content-backdrop fade"></div>
</div>
@endsection
@section('scripts')
@include('visit.show.__script')
@include('visit.product.__script')
@include('visit.file.__script')
@include('visit.crm_event.__script')
@include('visit.contact.__script')
@endsection