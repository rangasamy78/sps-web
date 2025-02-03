@extends('layouts.admin')

@section('title', 'Show Hold')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>

@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-2">
            <div class="col-6">
                <h4 class="card-title mb-0 fw-bold">
                    <span class="text-dark fw-bold">Show Hold # {{$hold->hold_code}}</span><br>
                </h4>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end"> <!-- Container for buttons -->
                    @if ($hold->is_released==0)
                    <a href="{{ route('hold.holds.edit', $hold->id) }}"
                        data-id="{{ $hold->id }}"
                        class="btn editbtn text-dark fw-bold"
                        data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Update Hold"
                        style="width: 25px; height: 38px; display: flex; align-items: center; justify-content: center;">
                        <i class="fi fi-rr-pen-circle fs-2"></i>
                    </a>
                    @endif
                    <div class='dropdown ms-2'> <!-- Add margin to separate buttons -->
                        <button type='button' class='btn p-0 dropdown-toggle hide-arrow text-dark fw-bold rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class='fi fi-rr-circle-ellipsis fs-2' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="More"></i> <!-- Icon inside the button -->
                        </button>
                        <div class='dropdown-menu'>
                            @if ($hold->is_released==0)
                            <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('hold.index_release', $hold->id) }}'>
                                <i class="fi fi-rr-puzzle-alt"></i> Release this Hold
                            </a>
                            <a class='dropdown-item showbtn fw-bold text-dark' href='javascript:void(0);'>
                                <i class="fi fi-rr-money-bill-transfer"></i> To be Transferred
                            </a>
                            @endif
                            <a class='dropdown-item deletebtn fw-bold text-dark' href='javascript:void(0);' data-id='{{ $hold->id }}'>
                                <i class="fi fi-rr-refresh"></i>Update Bin Numbers
                            </a>
                            <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('opportunities.index') }}'>
                                <i class="fi fi-rr-newspaper"></i> View Hold Costing Report
                            </a>
                            <a class='dropdown-item fw-bold text-dark' href='{{route('opportunities.index')}}?tab=holds' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                <i class='bx bx-list-ul'></i> List all Holds
                            </a>
                            <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                <i class='bx bxs-user-detail'></i></i> View Log
                            </a>
                            <a class='dropdown-item fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="coming soon">
                                <i class='bx bx-purchase-tag-alt'></i> Backend Details
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="app-ecommerce">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-header">

                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                    <input type="hidden" name="opportunity_id" id="opportunity_id" value="{{$opportunity->id}}">
                                    <input type="hidden" name="hold_id" id="hold_id" value="{{$hold->id}}">
                                    <div class="row p-1">
                                        <span>{{$holdDate}}</span>
                                    </div>
                                    <div class="row p-1">
                                        <span>Created from Opportunity # <span class="fw-bold text-dark">{{$opportunity->opportunity_code}}</span> by <span class="fw-bold text-dark">{{$loginPerson->first_name??''}} {{$loginPerson->last_name??''}}</span> on <span class="fw-bold text-dark">{{$opportunity_date}}</span>
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
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row p-1">
                                        <span class="text-danger fw-bold">{{$expiryDay}} </span>
                                    </div>
                                </div>
                                <div class="col-lg-1">&nbsp;</div>
                                <div class="col-lg-5 col-sm-12 mt-1 d-flex justify-content-end">
                                    <div class="progress w-75 mt-2 ">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: 50%; background-color: rgba(105, 173, 26, 0.56);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span class="fw-bold">Hold Date: {{ \Carbon\Carbon::parse($hold->hold_date)->format('M d, Y') }}</span></div>
                                        <div class="progress-bar progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: 50%; background-color: rgba(220, 42, 15, 0.72);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span class="fw-bold">Expiry Date: {{ \Carbon\Carbon::parse($hold->expiry_date)->format('M d, Y') }}</span></div>
                                    </div>
                                </div>
                            </div>
                            @if ($hold->is_released==0)
                            <div class="text-dark fw-bold text-end small"> <a class='dropdown-item showbtn fw-bold text-dark' href='{{ route('hold.index_release', $hold->id) }}'> Release this Hold</a></div>
                            @else
                            <div class="text-danger fw-bold text-end small"><span>Release this Hold: {{$releaseDate}}</span></div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 border-end border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Bill To</label>
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$customer->customer_name}}</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <address class="text-dark" style="font-size: 8pt;">
                                                {{$customer->address ?? ''}} {{$customer->city ?? ''}}, {{$customer->state ?? ''}} - {{$customer->zip}}
                                            </address>
                                        </div>
                                    </div>
                                    @if(optional($hold)->bill_to_fax)
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-rr-fax fw-bold"></i>{{$hold->bill_to_fax}}</span>
                                    </div>
                                    @endif
                                    @if(optional($hold)->bill_to_mobile)
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-rr-phone-office fw-bold text-dark"></i>{{$hold->bill_to_mobile}}</span>
                                    </div>
                                    @endif
                                    @if(optional($primarySale)->first_name)
                                    <div class="row mt-2">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Primary Sales Persons <div class="text-dark fw-bold" style="font-size:8pt">{{$primarySale->first_name??''}}</div></label>
                                        </div>
                                    </div>
                                    @endif
                                    @if(optional($secondarySale)->first_name)
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Secondary Sales Persons <div class="text-dark fw-bold" style="font-size:8pt">{{$secondarySale->first_name??''}}</div></label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-2 col-sm-6 border-end border-dark">
                                    <label class="form-label text-primary" style="font-size:8pt">Job / Home Owner</label>
                                    @if(optional($opportunity)->ship_to_job_name)
                                    <div class="row">
                                        <div class="col"><span class="text-dark fw-bold" style="font-size:10pt">{{$opportunity->ship_to_job_name}}</span></div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <address class="text-dark" style="font-size:8pt">
                                            {{$opportunity->ship_to_address}}
                                            @if($opportunity->ship_to_suite) {{$opportunity->ship_to_suite}} @endif
                                            {{$opportunity->ship_to_city}}
                                            @if($opportunity->ship_to_city && $opportunity->ship_to_state) , @endif
                                            {{$opportunity->ship_to_state}} {{$opportunity->ship_to_zip}}

                                        </address>
                                    </div>
                                    @if(optional($hold)->mobile)
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-rr-phone-flip fw-bold"></i>{{$hold->mobile}}</span>
                                    </div>
                                    @endif
                                    @if(optional($hold)->email)
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-rr-envelope fw-bold"></i>{{$hold->email}}</span>
                                    </div>
                                    @endif
                                    @if(optional($hold)->fax)
                                    <div class="row">
                                        <span class="text-dark" style="font-size:9pt"><i class="fi fi-rr-fax fw-bold"></i>{{$hold->fax}}</span>
                                    </div>
                                    @endif
                                    @if(optional($secondarySale))
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label class="form-label text-primary" style="font-size:8pt">Location <div class="text-dark fw-bold" style="font-size:8pt">{{$company->company_name}}</div></label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-sm-6 border-end border-dark">
                                    @if(optional($fabricator)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">Fabricator <div class="text-dark fw-bold" style="font-size:8pt">{{$fabricator->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($designer)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">Designer <div class="text-dark fw-bold" style="font-size:8pt">{{$designer->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($builder)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">Builder <div class="text-dark fw-bold" style="font-size:8pt">{{$builder->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($generalConstructor)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">General Contractor <div class="text-dark fw-bold" style="font-size:8pt">{{$generalConstructor->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                    @if(optional($brand)->associate_name)
                                    <div class="row">
                                        <label class="form-label text-primary" style="font-size: 8pt;">
                                            Brand <div class="text-dark fw-bold" style="font-size: 8pt;">{{ $brand->associate_name ?? '' }}</div>
                                        </label>
                                    </div>
                                    @endif
                                    @if(optional($referredBy)->associate_name)
                                    <div class=" row">
                                        <label class="form-label text-primary" style="font-size:8pt">Referred By <div class="text-dark fw-bold" style="font-size:8pt">{{$referredBy->associate_name??''}}</div></label>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-2 col-sm-6 border-end border-dark">
                                    @if(optional($opportunityStage)->opportunity_stage)
                                    <div class="row">
                                        <span class="form-label text-primary" style="font-size:8pt">Opportunity Stage <div class="text-dark fw-bold" style="font-size:8pt">{{$opportunityStage->opportunity_stage??''}}</div></span>
                                    </div>
                                    @endif
                                    @if(optional($hold)->customer_po)
                                    <div class="row">
                                        <span class="form-label text-primary" style="font-size:8pt">Customer PO# <div class="text-dark fw-bold" style="font-size:8pt">{{$hold->customer_po??''}}</div></span>
                                    </div>
                                    @endif
                                    @if(optional($paymentTerm)->payment_label)
                                    <div class="row">
                                        <span class="form-label text-primary" style="font-size:8pt">Payment Terms <div class="text-dark fw-bold" style="font-size:8pt">{{$paymentTerm->payment_label??''}}</div></span>
                                    </div>
                                    @endif
                                    @if(optional($priceList)->price_label)
                                    <div class="row">
                                        <span class="form-label text-primary" style="font-size:8pt">Price Level <div class="text-dark fw-bold" style="font-size:8pt">{{$priceList->price_label??''}}</div></span>
                                    </div>
                                    @endif
                                    @if(optional($hold)->pick_ticket_restriction)
                                    <div class="row">
                                        <span class="form-label text-primary" style="font-size:8pt">PickTicket Restriction <div class="text-dark fw-bold" style="font-size:8pt">{{$hold->pick_ticket_restriction??''}}</div></span>
                                    </div>
                                    @endif
                                    @if(optional($howDidHear)->how_did_you_hear_option)
                                    <div class="row">
                                        <span class="form-label text-primary" style="font-size:8pt">Marketing Channel <div class="text-dark fw-bold" style="font-size:8pt">{{$howDidHear->how_did_you_hear_option??''}}</div></span>
                                    </div>
                                    @endif

                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label text-dark fw-bold" style="font-size:9pt">Probability</label>
                                            <select class="form-control form-control-sm w-75" id="probability_to_close_id" name="probability_to_close_id">
                                                <option value="" disabled selected>--select--</option>
                                                @foreach($data['probabilityCloses'] as $id => $probability_close)
                                                <option value="{{ $id }}" {{ $hold->probability_to_close_id == $id ? 'selected' : '' }}>
                                                    Probability - {{ $probability_close }}%
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col">
                                            <label class="form-label text-dark fw-bold" style="font-size:9pt">Stage</label>
                                            <select type="select" class="form-select form-select-sm w-75" id="opportunity_stage_id" name="opportunity_stage_id">
                                                <option value="" disabled selected>--select--</option>
                                                @foreach($data['opportunityStages'] as $id => $opportunity_stage)
                                                <option value="{{ $id }}" {{ $opportunity->opportunity_stage_id == $id ? 'selected' : '' }}>{{ $opportunity_stage}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col">
                                            <label class="form-label fw-bold text-dark">Survey Rating </label>
                                            <div id="survey-rating" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#surveyRateModel">
                                                @for ($i=0;$i<=9;$i++)
                                                    <i class="fi fi-rr-star text-dark"></i>
                                                    @endfor
                                                    <i class="fi fi-rr-clip-mail text-primary fw-dark"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($contacts)&& count($contacts) > 0)
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label fw-bold text-dark" style="font-size:8pt">Contact</label>
                                            <div class="col showContact">
                                                @foreach ($contacts as $contact)
                                                <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_{{ $contact['hold_contact_id'] }}">
                                                    <span class="fw-semibold">{{ $contact['name'] }}</span>
                                                    <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="{{ $contact['hold_contact_id'] }}">
                                                        <i class="fas fa-trash-alt fa-xs"></i> <!-- Apply the size class here -->
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row border-bottom border-dark mt-3">
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <label class="form-label mb-0 fw-bold text-dark">Add More Internal Notes</label>
                                            <div class="d-flex align-items-center">
                                                <input type="hidden" id="logged_in_user" value="{{ auth()->user()->first_name??'' }}">
                                                <textarea rows="1" class="form-control" name="internal_notes" id="internal_notes"></textarea>
                                                <button type="button" class="btn ms-6" id="updateInternalNote" name="updateInternalNote">
                                                    <i class="fas fa-save fa-xl text-dark ms-6"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @if(optional($hold)->internal_notes)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Internal Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="internal_notes_input">{{$hold->internal_notes}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    @if(optional($hold)->printed_notes)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Printed Notes</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="printed_notes" name="printed_notes">{{$hold->printed_notes}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                    @if(optional($opportunity)->special_instructions)
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-bold text-dark">Special Instructions</label>
                                            <textarea class="form-control bg-label-warning text-dark" readonly rows="1" id="special_notes_input" name="special_instructions">{{$opportunity->special_instructions}}</textarea>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#holdProduct">
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
                                        @include('hold.product.products')
                                        @include('hold.file.files')
                                        @include('hold.crm_event.crm_events')
                                        @include('hold.contact.contacts')
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
@include('hold.show.__model');
<div class="content-backdrop fade"></div>
</div>
@endsection
@section('scripts')
@include('hold.show.__script')
@include('hold.product.__script')
@include('hold.file.__script')
@include('hold.crm_event.__script')
@include('hold.contact.__script')
@endsection