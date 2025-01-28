@extends('layouts.admin')

@section('title', 'Show Opportunity')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4"><a href="{{route('opportunities.index')}}" class="text-decoration-none text-dark "><span class="text-muted fw-light">Opportunity /</span><span> Show Opportunity</span></a></h4>

        <div class="app-ecommerce">
            <div class="row">
                <!-- first column -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">
                                <span class="text-dark fw-bold">Delivery Opportunity # {{$opportunity->opportunity_code}} {{$opportunity->ship_to_job_name}} @ <a href="{{route('companies.index')}}">{{$company->company_name}}</a></span>
                            </h4>
                            <div class="d-flex align-items-center"> <!-- Container for buttons -->
                                <a href="{{ route('opportunities.edit', $opportunity->id) }}"
                                    data-id="{{ $opportunity->id }}"
                                    class="btn btn-primary rounded-circle editbtn"
                                    data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Update Opportunity"
                                    style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fi fi-rr-pencil fs-4" style="font-size: 18px;"></i>
                                </a>
                                <div class='dropdown ms-2'> <!-- Add margin to separate buttons -->
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow btn-primary rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        <i class='fi fi-rr-redo icon-color fs-4' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="More"></i> <!-- Icon inside the button -->
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('opportunities.index') }}?tab=opportunities'>
                                            <i class='bx bx-list-ul'></i> List All opportunity
                                        </a>
                                        <a class='dropdown-item deletebtn fw-bold text-dark' href='javascript:void(0);' data-id='{{ $opportunity->id }}'>
                                            <i class='bx bx-trash me-1 icon-danger'></i> Delete this opportunity
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bx-duplicate'></i> Duplicate opportunity Record
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxs-user-detail'></i></i> Duplicate Opportunity with All Quotes
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bx-purchase-tag-alt'></i> Close Opportunity
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxs-file-plus'></i> Credit,Tier,Tax,Terms Changes
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxl-paypal'></i> View Log
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bxs-report'></i> Backend Details
                                        </a>
                                        <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                            <i class='bx bx-list-check'></i> View Map
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <!-- <label for="print_name" class="form-label text-dark fw-bold">Print Name / DBA:</label> -->
                                            @if(optional($date))
                                            <span id="print_name_value" class="d-block">
                                                {{ $date }}
                                            </span>
                                            @endif
                                            @if(optional($user)->first_name)
                                            <label for="created_by" class="form-label text-dark fw-bold font-size" style="font-size:8pt">Created By</label>
                                            <span id="created_by_value" style="font-size:9pt"> {{$user->first_name}} {{$user->last_name}} <span class="form-label text-dark fw-bold">on</span> {{$opportunity_date}}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                @if(optional($taxcode)->tax_code_label)
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <span id="print_name_value" class="d-block">
                                                {{ $taxcode->tax_code_label }}

                                            </span>
                                            <label for="created_by" class="form-label text-dark fw-bold" style="font-size:8pt">Sales Tax</label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row mb-2">
                                        @if(optional($price_list)->price_code)
                                        <div class="col-6">
                                            <span id="print_name_value" class="d-block">
                                                {{ $price_list->price_code }}-{{ $price_list->price_label }}
                                            </span>
                                            <label for="created_by" class="form-label text-dark fw-bold" style="font-size:8pt">Price Level</label>
                                        </div>
                                        @endif
                                        @if(optional($payment_term)->payment_label)
                                        <div class="col-6">
                                            <span id="print_name_value" class="d-block">
                                                {{ $payment_term->payment_label }}
                                            </span>
                                            <label for="created_by" class="form-label text-dark fw-bold" style="font-size:8pt">Payment Terms</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="row d-flex justify-content-end">
                                        <!-- Box 1 -->
                                        @if($visitCount)
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">{{$visitCount}}</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">Visit</p>
                                            </div>
                                        </div>
                                        @endif
                                        <!-- Box 2 -->
                                        @if($sampleOrderCount)
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">{{$sampleOrderCount}}</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">S.Order</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($holdCount)
                                        <!-- Box 3 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">{{$holdCount}}</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">Hold</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($quoteCount)
                                        <!-- Box 4 -->
                                        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                            <div class="small-box text-center">
                                                <h6 class="mb-2">{{$quoteCount}}</h6>
                                                <p class="bg-dark text-white" style="font-size: 0.75rem;">Quote</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Bill To:
                                        <input type="hidden" class="form-input customer_id" id="customer_id" name="customer_id" value="{{ $customer->id }}">
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$customer->customer_name}}</span>
                                    </h6>
                                    <div class="row">
                                        <div class="col"><label class="form-label">{{$customer->address}}</label></div>
                                    </div>
                                    @if (optional($customer)->phone)
                                    <div class="row">
                                        <div class="col">
                                            <i class='bx bx-phone-call text-dark'></i>
                                            <label class="form-label ms-1">{{ $customer->phone }}</label>
                                        </div>
                                    </div>
                                    @endif
                                    @if (optional($customer)->email)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-envelope text-dark'></i><label class="form-label ms-1">{{$customer->email}}</label></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Ship To:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$opportunity->ship_to_name}}</span>
                                    </h6>
                                    @if (optional($opportunity)->ship_to_address)
                                    <div class="row">
                                        <div class="col"><label class="form-label">{{$opportunity->ship_to_address}}</label></div>
                                    </div>
                                    @endif
                                    @if (optional($opportunity)->ship_to_phone)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-phone-call text-dark'></i><label class="form-label ms-1">{{$opportunity->ship_to_phone}}</label></div>
                                    </div>
                                    @endif
                                    @if ($opportunity->ship_to_email)
                                    <div class="row">
                                        <div class="col"><i class='bx bx-envelope text-dark'></i><label class="form-label ms-1">{{$opportunity->ship_to_email}}</label></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center p-2 rounded">
                                        Location:
                                        <span class="text-dark" style="font-size: 0.75rem;">{{$company->company_name}}</span>
                                    </h6>
                                    <div class="row">
                                        <div class="col"> @if(optional($primary_sales)->first_name)<i class='bx bx-user text-dark'></i><label class="form-label ms-1">{{$primary_sales->first_name}}&nbsp;{{$primary_sales->last_name}}</label>@else
                                            <!-- No secondary sales person assigned -->
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            @if(optional($secondary_sales)->first_name)<i class="bx bx-user text-dark"></i><label class="form-label ms-1">{{ $secondary_sales->first_name }} &nbsp;{{ $secondary_sales->last_name }}</label>
                                            @else
                                            <!-- No secondary sales person assigned -->
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col"><span class="text-dark ms-1" style="font-size:0.75rem">How did you hear about us?</span><label class="form-label ms-1">&nbsp;{{$how_did_hear->how_did_you_hear_option ?? 'N/A'}}</label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <h6 class="bg-label-primary text-white text-center d-flex justify-content-between p-2 rounded">
                                        Contacts:
                                        <span class="text-dark">
                                            <i class="bx bxs-plus-circle align-middle fs-6" data-bs-toggle="modal" data-bs-target="#listCustomerContact"></i>
                                        </span>
                                    </h6>
                                    <div class="row">
                                        <div class="col showContact">
                                            @foreach ($contacts as $contact)
                                            <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_{{ $contact['opportunity_contact_id'] }}">
                                                <span class="fw-semibold">{{ $contact['name'] }}</span>
                                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="{{ $contact['opportunity_contact_id'] }}">
                                                    <i class="fas fa-trash-alt fa-xs"></i> <!-- Apply the size class here -->
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 row_internal_notes">

                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label mb-0 fw-bold text-dark">Add More Internal Notes</label>
                                    <div class="d-flex align-items-center">
                                        <input type="hidden" id="logged_in_user" value="{{ auth()->user()->first_name }}">
                                        <textarea rows="1" class="form-control" name="internal_notes" id="internal_notes"></textarea>
                                        <button type="button" class="btn ms-6" id="updateInternalNote" name="updateInternalNote">
                                            <i class="fas fa-save fa-xl text-dark"></i>
                                        </button>
                                    </div>
                                </div>
                                @if(optional($opportunity)->internal_notes)
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label fw-bold text-dark">Internal Notes</label>
                                    <textarea class="form-control" readonly rows="1" id="internal_notes_input">{{$opportunity->internal_notes}}</textarea>
                                </div>
                                @endif
                            </div>
                            <div class="row mt-3">
                                @if(optional($opportunity)->special_instructions)
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label fw-bold text-dark">Special / Delivery Instructions</label>
                                    <textarea class="form-control" rows="1" readonly id="special_instructions" name="special_instructions">{{$opportunity->special_instructions}}</textarea>
                                </div>
                                @endif
                                <div class="col-lg-2 col-sm-5">
                                    <label class="form-label fw-bold text-dark">Probability</label>
                                    <select class="form-control" id="probability_to_close_id" name="probability_to_close_id">
                                        <option value="" disabled selected>--select--</option>
                                        @foreach($data['probabilityCloses'] as $id => $probability_close)
                                        <option value="{{ $id }}" {{ $opportunity->probability_to_close_id == $id ? 'selected' : '' }}>
                                            {{ $probability_close }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-lg-2 col-sm-5">
                                    <label class="form-label fw-bold text-dark">Stage</label>
                                    <select class="form-control" id="opportunity_stage_id" name="opportunity_stage_id">
                                        <option value="" disabled selected>--select--</option>
                                        @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                        <option value="{{ $id }}" {{ $opportunity->opportunity_stage_id == $id ? 'selected' : '' }}>{{ $opportunity_stage}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    <label class="form-label fw-bold text-dark">Total Value</label><br>
                                    <input type="text" id="totalSum" hidden readonly class="form-control" placeholder="Total" value="{{$total}}">
                                    <span class="">$ {{$total}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /first column -->
            </div>
            <!-- buttons for visit,holds,sample order,quotes -->
            <div class="row mb-3">
                <div class="col-3   ">
                    <label for="survey-rating" class="form-label">Survey Rating:</label>
                    <div id="survey-rating" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#surveyRateModel">
                        @for ($i=0;$i<=8;$i++)
                            <i class="fi fi-rr-star text-dark"></i>
                            @endfor
                            <i class="fi fi-rr-clip-mail text-primary fw-dark"></i>
                    </div>
                </div>

                <div class="col-9 text-end p-3">
                    <button
                        type="button"
                        class="btn btn-dark btn-sm"
                        onclick="window.location.href='{{ route('visits.opportunity_detail', $opportunity->id) }}'">
                        <i class="fi fi-rr-plus me-2"></i> Visit
                    </button>
                    <button type="button" class="btn btn-dark  btn-sm" onclick="window.location.href='{{ route('create.index_sample_order', $opportunity->id) }}'"><i class="fi fi-rr-plus me-2"></i> Sample Order</button>
                    <button type="button" class="btn btn-dark  btn-sm" onclick="window.location.href='{{ route('quote.index_quote', $opportunity->id) }}'"><i class="fi fi-rr-plus me-2"></i> Quotes</button>
                    <button type="button" class="btn btn-dark  btn-sm" onclick="window.location.href='{{ route('hold.index_hold', $opportunity->id) }}'"><i class="fi fi-rr-plus me-2"></i> Holds</button>
                    <button type="button" class="btn btn-dark  btn-sm"><i class="fi fi-rr-plus me-2"></i> Sales Order</button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Options -->
                        <div class="col-12">
                            <div class="tab-content p-0 pe-md-5">
                                <div class="tab-pane fade show active" id="allOpportunity" role="tabpanel">
                                    <h5 class="card-title">Subtransactions</h5>
                                    <div class="d-flex justify-content-between align-items-center row py-3 gap-2 gap-md-0">
                                    </div>
                                    <div class="card-datatable table-responsive">
                                        <table class="datatables-basic table tables-basic border-top table-striped" id="datatableSubTransction">
                                            <thead class="table-header-bold">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Days</th>
                                                    <th>Expiry Date</th>
                                                    <th>Transaction #</th>
                                                    <th>Project Type</th>
                                                    <th>End-Use Segment</th>
                                                    <th>Label</th>
                                                    <th>Total</th>
                                                    <th>Sales Orders</th>
                                                    <th>actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Options-->
                    </div>
                </div>
            </div>

            <!-- //tab of crm event,files and contacts -->
            <div class="row">
                <div class="col-12 order-0 order-md-1">
                    <!-- Navigation -->
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#file">
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
                                        @include('opportunity.file.files')
                                        @include('opportunity.crm_event.crm_events')
                                        @include('opportunity.contact.contacts')
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
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
    @include('opportunity.show.__model')
</div>

@endsection
@section('scripts')
@include('opportunity.file.__script')
@include('opportunity.show.__script')
@include('opportunity.__script')
@include('opportunity.crm_event.__script')
@include('opportunity.contact.__script')
@endsection