@extends('layouts.admin')

@section('title', 'Show Quote')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<style>
    #optionLineItemTable {
        font-size: 12px;
        /* Adjust font size as needed */
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-7 col-sm-12">
                <h4 class="py-2 mb-1 text-dark"><span class="text-primary">Quote# {{$opportunity->opportunity_code}} - {{$position}}</span> {{$customer->customer_name}}@ {{$company->company_name}}-{{$company->state}} <span class="text-danger fw-bold showStatus">{{ $quote->status == 'close' ? 'Closed' : '' }}</span></a></h4>
            </div>
            <div class="col-lg-5 col-sm-12">
                <div class="d-flex justify-content-end"> <!-- Container for buttons -->
                    <a href="{{ route('quote.quotes.edit', $quote->id) }}"
                        data-id="{{ $quote->id }}"
                        class="btn editbtn text-dark fw-bold"
                        data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Update Quote"
                        style="width: 25px; height: 38px; display: flex; align-items: center; justify-content: center;">
                        <i class="fi fi-rr-pen-circle fs-2"></i>
                    </a>
                    <a href="javascript:void(0);"
                        data-id="{{ $quote->id }}"
                        class="btn text-dark fw-bold rounded-circle deletebtn ms-2"
                        data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Delete Quote"
                        style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                        <i class="fi fi-rr-cross-circle fs-2" style="font-size: 18px;"></i>
                    </a>
                    <div class='dropdown ms-2'>
                        <button type='button' class='btn p-0 dropdown-toggle hide-arrow text-dark fw-bold rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class='fi fi-rr-circle-ellipsis fs-2' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="More"></i> <!-- Icon inside the button -->
                        </button>
                        <div class='dropdown-menu'>
                            <a class='dropdown-item showbtn fw-bold text-dark' href='javascript:void(0);'>
                                <i class='bx bx-list-ul'></i> Duplicate Quote
                            </a>
                            <a class='dropdown-item showbtn fw-bold text-dark' href='javascript:void(0);'>
                                <i class='bx bx-list-ul'></i> Duplicate Quote with Opportunity
                            </a>
                            <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="modal" data-bs-target="#statusModel">
                                <i class='bx bx-list-ul'></i> <span class="quote_status">{{ $quote->status == 'close' ? 'Open Quote' : 'Close Quote' }}</span>
                            </a>
                            <a class='dropdown-item deletebtn fw-bold text-dark' href='javascript:void(0);' data-id='{{ $quote->id }}'>
                                <i class='bx bx-trash me-1 icon-danger'></i> Delete Quote
                            </a>
                            <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('opportunities.index') }}?tab=quotes'>
                                <i class='bx bx-list-ul'></i> List All Quote
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

        <input type="hidden" name="quote_id" id="quote_id" value="{{$quote->id}}">
        <input type="hidden" name="customer_id" id="customer_id" value="{{$customer->id}}">
        <div class="app-ecommerce">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <div class="row p-1">
                                        <span>{{$quoteDate}}</span>
                                    </div>
                                    <div class="row p-1">
                                        <span style="font-size:9pt">Created from Opportunity # <span class="fw-bold text-dark">{{$opportunity->opportunity_code}}</span> by <span class="fw-bold text-dark">{{$loginPerson->first_name}} {{$loginPerson->last_name}}</span> on <span class="fw-bold text-dark">{{$opportunity_date}}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="row test-end">
                                        @if (optional($taxCode)->tax_code_label)
                                        <div class="col-lg-4 col-sm-6">
                                            <div>
                                                <label style="font-size:10pt">{{$taxCode->tax_code_label}}</label>
                                            </div>
                                            <label class="text-dark fw-bold" style="font-size:9pt">Sales Tax</label>
                                        </div>
                                        @endif
                                        @if (optional($priceList)->price_level)
                                        <div class="col-lg-4 col-sm-6">
                                            <div>
                                                <label style="font-size:10pt">{{$priceList->price_level}}</label>
                                            </div>
                                            <label class="text-dark fw-bold" style="font-size:9pt">Price Level</label>
                                        </div>
                                        @endif
                                        @if (optional($paymentTerm)->payment_label)
                                        <div class="col-lg-4 col-sm-6">
                                            <div>
                                                <label style="font-size:10pt">{{$paymentTerm->payment_label}}</label>
                                            </div>
                                            <span class="text-dark fw-bold" style="font-size:9pt">Payment Terms</span>
                                        </div>
                                        @endif
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
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Bill To:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$customer->customer_name}}</span>
                                    </h6>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$customer->customer_name}}</span></div>
                                    </div>
                                    <div class="row">
                                        <span class="text-dark" style="font-size:8pt">
                                            {{ $customer->address }}
                                            @if($customer->address_2)
                                            <br>{{ $customer->address_2 }}
                                            @endif
                                            <br>{{ $customer->city }},
                                            {{ $customer->state }} {{ $customer->zip }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Ship To:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$opportunity->ship_to_job_name}}</span>
                                    </h6>
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
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Location:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$company->company_name}}</span>
                                    </h6>
                                    @if (optional($endUseSegment)->end_use_segment)
                                    <div class="row border-bottom border-light">
                                        <label class="m-1 text-primary" style="font-size:8pt">End-Use Segment:&nbsp;<span class="text-dark fw-bold">{{ $endUseSegment->end_use_segment ?? '' }}</span></label>
                                    </div>
                                    @endif
                                    @if (optional($projectType)->project_type_name)
                                    <div class="row border-bottom border-light">
                                        <label class="m-1 text-primary" style="font-size:8pt">Project Type:&nbsp;<span class="text-dark fw-bold">{{ $projectType->project_type_name ?? '' }}</span></label>
                                    </div>
                                    @endif
                                    @if (optional($primarySale)->first_name)
                                    <div class="row border-bottom border-light">
                                        <label class="m-1 text-primary" style="font-size:8pt"><i class="fi fi-rr-user"></i>:&nbsp;<span class="text-dark fw-bold">{{ $primarySale->first_name ?? '' }} {{ $primarySale->last_name ?? '' }}</span></label>
                                    </div>
                                    @endif
                                    @if (optional($secondarySale)->first_name)
                                    <div class="row border-bottom border-light">
                                        <label class="m-1 text-primary" style="font-size:8pt"><i class="fi fi-rr-user"></i>:&nbsp;<span class="text-dark fw-bold">{{ $secondarySale->first_name ?? '' }} {{ $secondarySale->last_name ?? '' }}</span></label>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    <!-- associate -->
                                    @if($fabricator || $designer || $builder)
                                    <h6 class="bg-label-primary text-white text-center p-1 rounded">Associates</h6>
                                    @if($fabricator)
                                    <div class="row border-bottom border-light">
                                        <label class="m-1 text-primary" style="font-size:8pt">Fabricator:&nbsp;<span class="text-dark fw-bold">{{ $fabricator->associate_name ?? '' }}</span></label>
                                    </div>
                                    @endif
                                    @if($designer)
                                    <div class="row border-bottom border-light">
                                        <label class="m-1 text-primary" style="font-size:8pt">Designer:&nbsp;<span class="text-dark fw-bold">{{ $designer->associate_name ?? '' }}</span></label>
                                    </div>
                                    @endif
                                    @if($builder)
                                    <div class="row">
                                        <label class="m-1 text-primary" style="font-size:8pt">Builder:&nbsp;<span class="text-dark fw-bold">{{ $builder->associate_name ?? '' }}</span></label>
                                    </div>
                                    @endif
                                    @endif
                                    <!-- Contact -->
                                    <h6 class="bg-label-primary text-white text-center d-flex justify-content-between p-1 rounded mt-1">
                                        Contacts
                                        <span class="text-dark">
                                            <i class="bx bxs-plus-circle align-middle fs-6" data-bs-toggle="modal" data-bs-target="#listCustomerContact"></i>
                                        </span>
                                    </h6>
                                    <div class="row">
                                        <div class="col showContact">
                                            @foreach ($contacts as $contact)
                                            <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_{{ $contact['quote_contact_id'] }}">
                                                <span class="fw-semibold">{{ $contact['name'] }}</span>
                                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="{{ $contact['quote_contact_id'] }}">
                                                    <i class="fas fa-trash-alt fa-xs"></i> <!-- Apply the size class here -->
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$quote->quote_internal_note}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <label class="form-label mb-0 fw-bold text-dark">Add More Internal Notes</label>
                                            <div class="d-flex align-items-center">
                                                <input type="hidden" id="logged_in_user" value="{{ auth()->user()->first_name }}">
                                                <textarea rows="1" class="form-control" name="quote_internal_note" id="quote_internal_note"></textarea>
                                                <button type="button" class="btn ms-6" id="updateInternalNote" name="updateInternalNote">
                                                    <i class="fas fa-save fa-xl text-dark ms-6"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-dark">Probability</label>
                                            <select class="form-control" id="probability_close_id" name="probability_close_id">
                                                <option value="" disabled selected>--select--</option>
                                                @foreach($data['probabilityCloses'] as $id => $probability_close)
                                                <option value="{{ $id }}" {{ $quote->probability_close_id == $id ? 'selected' : '' }}>
                                                    {{ $probability_close }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-dark">Stage</label>
                                            <select class="form-control" id="opportunity_stage_id" name="opportunity_stage_id">
                                                <option value="" disabled selected>--select--</option>
                                                @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                                <option value="{{ $id }}" {{ $opportunity->opportunity_stage_id == $id ? 'selected' : '' }}>{{ $opportunity_stage}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-7">
                                            <label class="form-label fw-bold text-dark">Survey Rating </label>
                                            <div id="survey-rating" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#surveyRateModel">
                                                @for ($i=0;$i<=10;$i++)
                                                    <i class="fi fi-rr-star text-dark"></i>
                                                    @endfor
                                                    <i class="fi fi-rr-clip-mail text-primary fw-dark"></i>
                                            </div>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#lines">
                                        <i class='bx bxl-product-hunt me-2'></i>
                                        <span class="align-middle">Lines</span>
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
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quoteContact">
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
                                        @include('quote.line.lines')
                                        @include('quote.file.files')
                                        @include('quote.crm_event.crm_events')
                                        @include('quote.contact.contacts')

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
@include('quote.show.__model')
<!-- / Content -->
<div class="content-backdrop fade"></div>
</div>
@endsection
@section('scripts')
@include('quote.show.__script')
@include('quote.file.__script')
@include('quote.crm_event.__script')
@include('quote.contact.__script')
@include('quote.line.__script')
@endsection