@extends('layouts.admin')

@section('title', 'Show Sample Order')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>


@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span> Show Sample Order</span></a></h4>
        <div class="app-ecommerce">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-header">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <h4 class="card-title mb-0 fw-bold">
                                        <span class="text-dark fw-bold">Sample Order # {{$opportunity->opportunity_code}} - {{$position}}</span><br>
                                    </h4>
                                </div>
                                <div class="col">
                                    <div class="d-flex justify-content-end"> <!-- Container for buttons -->
                                        <a href="{{ route('create.edit', $sampleOrder->id) }}"
                                            data-id="{{ $sampleOrder->id }}"
                                            class="btn editbtn text-dark fw-bold"
                                            data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Update Sample Order"
                                            style="width: 25px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fi fi-rr-pen-circle fs-2"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            data-id="{{ $sampleOrder->id }}"
                                            class="btn text-dark fw-bold rounded-circle deletebtn ms-2"
                                            data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Delete Sample Order"
                                            style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fi fi-rr-cross-circle fs-2" style="font-size: 18px;"></i>
                                        </a>
                                        <div class='dropdown ms-2'> <!-- Add margin to separate buttons -->
                                            <button type='button' class='btn p-0 dropdown-toggle hide-arrow text-dark fw-bold rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                <i class='fi fi-rr-circle-ellipsis fs-2' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="More"></i> <!-- Icon inside the button -->
                                            </button>
                                            <div class='dropdown-menu'>
                                                <a class='dropdown-item showbtn fw-bold text-dark' href='javascript:void(0);'>
                                                    <i class='bx bx-list-ul'></i> Duplicate Sample Order
                                                </a>
                                                <a class='dropdown-item showbtn fw-bold text-dark' href='javascript:void(0);'>
                                                    <i class='bx bx-list-ul'></i> Duplicate Sample Order with Opportunity
                                                </a>
                                                <a class='dropdown-item deletebtn fw-bold text-dark' href='javascript:void(0);' data-id='{{ $sampleOrder->id }}'>
                                                    <i class='bx bx-trash me-1 icon-danger'></i> Delete Sample Order
                                                </a>
                                                <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('opportunities.index') }}?tab=samples'>
                                                    <i class='bx bx-list-ul'></i> List All Sample Order
                                                </a>
                                                <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                                    <i class='bx bx-duplicate'></i> View Log
                                                </a>
                                                <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                                    <i class='bx bxs-user-detail'></i></i> Backend Details
                                                </a>
                                                <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                                    <i class='bx bx-purchase-tag-alt'></i> Sample Products Slideshow
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
                                        <span>{{$sampleOrderDate}}</span>
                                    </div>
                                    <div class="row p-1">
                                        <span>Created from Opportunity # <span class="fw-bold text-dark">{{$opportunity->opportunity_code}}</span> by <span class="fw-bold text-dark">{{$loginPerson->first_name}} {{$loginPerson->last_name}}</span> on <span class="fw-bold text-dark">{{$opportunity_date}}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="row d-flex justify-content-end">
                                        <!-- Box 1 -->
                                        @if($visitCount)
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <a href="{{ route('opportunities.show', $opportunity->id) }}">
                                                <div class="small-box text-center">
                                                    <h6 class="mb-2">{{$visitCount}}</h6>
                                                    <p class="bg-dark text-white" style="font-size: 0.75rem;">Visit</p>
                                                </div>
                                            </a>
                                        </div>
                                        @endif
                                        <!-- Box 2 -->
                                        @if($sampleOrderCount)
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <a href="{{ route('opportunities.show', $opportunity->id) }}">
                                                <div class="small-box text-center">
                                                    <h6 class="mb-2">{{$sampleOrderCount}}</h6>
                                                    <p class="bg-dark text-white" style="font-size: 0.75rem;">S.Order</p>
                                                </div>
                                            </a>
                                        </div>
                                        @endif
                                        @if($holdCount)
                                        <!-- Box 3 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <a href="{{ route('opportunities.show', $opportunity->id) }}">
                                                <div class="small-box text-center">
                                                    <h6 class="mb-2">{{$holdCount}}</h6>
                                                    <p class="bg-dark text-white" style="font-size: 0.75rem;">Hold</p>
                                                </div>
                                            </a>
                                        </div>
                                        @endif
                                        @if($quoteCount)
                                        <!-- Box 4 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <a href="{{ route('opportunities.show', $opportunity->id) }}">
                                                <div class="small-box text-center">
                                                    <h6 class="mb-2">{{$quoteCount}}</h6>
                                                    <p class="bg-dark text-white" style="font-size: 0.75rem;">Quote</p>
                                                </div>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 border-end border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Bill To</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$customer->customer_name??''}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:8pt">{{$customer->address??''}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 border-end border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Job / Home Owner</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$opportunity->ship_to_job_name??''}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:8pt">
                                            {{$opportunity->ship_to_address??''}}
                                            @if($opportunity->ship_to_suite) {{$opportunity->ship_to_suite}} @endif
                                            {{$opportunity->ship_to_city}}
                                            @if($opportunity->ship_to_city && $opportunity->ship_to_state) , @endif
                                            {{$opportunity->ship_to_state}} {{$opportunity->ship_to_zip}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 border-end border-dark">
                                    @if(optional($fabricator)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">Fabricator<div class="text-dark fw-bold" style="font-size:9pt">{{$fabricator->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($designer)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">Designer <div class="text-dark fw-bold" style="font-size:9pt">{{$designer->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($builder)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">Builder<div class="text-dark fw-bold" style="font-size:9pt">{{$builder->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    @if(optional($sampleOrder)->attn)
                                    <div class="row">
                                        <label class="form-label text-primary" style="font-size:8pt">Samples Ship To<div class="text-dark fw-bold" style="font-size:10pt">{{$sampleOrder->attn}}</div></label>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <span class="text-dark" style="font-size:8pt">
                                            {{$sampleOrder->address??''}}
                                            @if($sampleOrder->suite) {{$sampleOrder->suite}} @endif
                                            {{$sampleOrder->city}}
                                            @if($sampleOrder->city && $sampleOrder->state) , @endif
                                            {{$sampleOrder->state}} {{$sampleOrder->zip}}
                                        </span>
                                    </div>
                                    @if($sampleOrder->tracking)
                                    <div class="row mt-2">
                                        <span class="text-dark" style="font-size:8pt"><span class="text-dark fw-bold">Tracking#:</span> {{$sampleOrder->tracking}}</span>
                                    </div>
                                    @endif
                                    @if (!empty($contacts)&& count($contacts)>0)
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Contact</label>
                                            <div class="col showContact">
                                                @foreach ($contacts as $contact)
                                                <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_{{ $contact['sample_order_contact_id'] }}">
                                                    <span class="fw-semibold">{{ $contact['name'] }}</span>
                                                    <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="{{ $contact['sample_order_contact_id'] }}">
                                                        <i class="fas fa-trash-alt fa-xs"></i> <!-- Apply the size class here -->
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="row m-1">
                                        <label class="text-primary" style="font-size:9pt">Probability</label>
                                        <select class="form-control form-control-sm w-75" id="probability_close_id" name="probability_close_id">
                                            <option value="" disabled selected>--select--</option>
                                            @foreach($data['probabilityCloses'] as $id => $probability_close)
                                            <option value="{{ $id }}" {{ $sampleOrder->probability_close_id == $id ? 'selected' : '' }}>
                                                Probability - {{ $probability_close }}%
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row m-1">
                                        <label class=" text-primary" style="font-size:9pt">Stage</label>
                                        <select type="select" class="form-select form-select-sm w-75" id="opportunity_stage_id" name="opportunity_stage_id">
                                            <option value="" disabled selected>--select--</option>
                                            @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                            <option value="{{ $id }}" {{ $opportunity->opportunity_stage_id == $id ? 'selected' : '' }}>{{ $opportunity_stage}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row m-1">
                                        <label class="text-primary" style="font-size:9pt">Status</label>
                                        <select type="select" class="form-select form-select-sm w-75" id="status" name="status">
                                            <option value="" disabled selected>--select--</option>
                                            @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ $sampleOrder->status == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    @if(optional($sampleOrder)->sample_order_printed_notes)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Printed Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="sample_order_printed_notes" name="sample_order_printed_notes">{{$sampleOrder->sample_order_printed_notes}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row mt-2">
                                        @if(optional($primarySale)->first_name)
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-dark">Primary Sales Persons</label>
                                            <div class="text-dark">{{$primarySale->first_name}} {{$primarySale->last_name}}</div>
                                        </div>
                                        @endif
                                        @if(optional($secondarySale)->first_name)
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-dark">Secondary Sales Persons</label>
                                            <div class="text-dark">{{$secondarySale->first_name}} {{$secondarySale->last_name}}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    @if(optional($opportunity)->internal_notes)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$opportunity->internal_notes}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                    @if(optional($opportunity)->special_instructions)
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Special Instructions</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="special_notes_input">{{$opportunity->special_instructions}}</textarea>
                                        </div>
                                    </div>
                                    @endif
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sampleOrderProduct">
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
                                        @include('sample_order.product.products')
                                        @include('sample_order.file.files')
                                        @include('sample_order.crm_event.crm_events')
                                        @include('sample_order.contact.contacts')
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
@include('sample_order.show.__script')
@include('sample_order.product.__script')
@include('sample_order.file.__script')
@include('sample_order.crm_event.__script')
@include('sample_order.contact.__script')
@endsection