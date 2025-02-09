@extends('layouts.admin')

@section('title', 'Customer')
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Customer Detail</h4>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 fw-bold">
                                {{ $customer->customer_name  }} ( {{ $customer->customer_code }})
                            </h4>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                    data-id="{{ $customer->id }}"
                                    class="btn btn-primary rounded-circle editbtn"
                                    data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" title="Edit Customer"
                                    style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-edit" style="font-size: 18px;"></i>
                                </a>
                                <div class='dropdown ms-2'>
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow btn-primary rounded-circle' data-bs-toggle='dropdown' aria-expanded="false" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        <i class='bx bx-plus-circle icon-color' data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-dark" title="Action"></i> <!-- Icon inside the button -->
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item showbtn text-warning' href='{{ route('customers.index') }}'>
                                            <i class='bx bx-list-ul'></i> List All Customer
                                        </a>
                                        @if(!$consignment->contains($customer->id))
                                        <a class='dropdown-item inactivebtn text-success change_status' data-id='{{ $customer->id }}'>
                                            <i class='bx bx-check-circle'></i> @if($customer->status == 0)Active Customer
                                            @else
                                            Inactive Customer
                                            @endif
                                        </a>
                                        @endif
                                        <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='{{ $customer->id }}'>
                                            <i class='bx bx-trash me-1 icon-danger'></i> Delete this Customer
                                        </a>
                                        @if($consignment->contains($customer->id))
                                        <!-- Show 'Remove Consignment Location' button -->
                                        <button type="button" class="btn dropdown-item text-dark deleteconsignment" id="deleteconsignment" name="deleteconsignment" data-id="{{ $customer->id }}">
                                            <i class='bx bx-check-circle'></i> Remove Consignment Location
                                        </button>
                                        @else
                                        <!-- Show 'Setup as Consignment Location' button -->
                                        <button type="button" class="btn dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#ConsignmentModel">
                                            <i class='bx bx-check-circle'></i> Setup as Consignment Location
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7 mt-3">
                    <div class="card">
                        <h5 class="card-header">Contact: {{ $customer->contact_name ?? '' }}</h5>
                        <div class="card-body">
                            <div class="row p-sm-3 p-0">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                    <h6 class="pb-2">Bill To:</h6>
                                    @if(!empty($customer->address))
                                        <p class="mb-1">{{ $customer->address }}</p>
                                    @endif
                                    @if(!empty($customer->state) || !empty($customer->city) || !empty($customer->zip))
                                        <p class="mb-1">
                                            {{ $customer->state ?? '' }}
                                            {{ $customer->city ?? '' }}
                                            {{ $customer->zip ?? '' }}
                                        </p>
                                    @endif
                                    @if(!empty($customer->county) || !empty($customer->country->country_name))
                                        <p class="mb-1">
                                            {{ $customer->county ?? '' }}
                                            {{ $customer->country->country_name ?? '' }}
                                        </p>
                                    @endif
                                    @if(!empty($customer->phone))
                                    <p class="mb-1">{{ "P : ". $customer->phone ?? ''}} </p>
                                    @endif
                                    @if(!empty($customer->phone_2))
                                    <p class="mb-1">{{ "P1 : ". $customer->phone_2 ?? ''}} </p>
                                    @endif
                                    @if(!empty($customer->fax))
                                    <p class="mb-1">{{ "F : ". $customer->fax ?? ''}} </p>
                                    @endif
                                    @if(!empty($customer->mobile))
                                    <p class="mb-1">{{ "M : ". $customer->mobile ?? ''}} </p>
                                    @endif
                                </div>
                                <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                    <h6 class="pb-2">Ship to:</h6>
                                    @if(!empty($customer->shipping_address))
                                        <p class="mb-1">{{ $customer->shipping_address }}</p>
                                    @endif

                                    @if(!empty($customer->shipping_state) || !empty($customer->shipping_city) || !empty($customer->shipping_zip))
                                        <p class="mb-1">
                                            {{ $customer->shipping_state ?? '' }}
                                            {{ $customer->shipping_city ?? '' }}
                                            {{ $customer->shipping_zip ?? '' }}
                                        </p>
                                    @endif

                                    @if(!empty($customer->county) || !empty($customer->shipping_country->country_name))
                                        <p class="mb-1">
                                            {{ $customer->county ?? '' }}
                                            {{ $customer->shipping_country->country_name ?? '' }}
                                        </p>
                                    @endif
                                    @if(!empty($customer->email))
                                    <p class="mb-1">{{ "E : ". $customer->email ?? ''}} </p>
                                    @endif
                                    @if(!empty($customer->accounting_email))
                                    <p class="mb-1">{{ "A.E : ". $customer->accounting_email ?? ''}} </p>
                                    <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='{{ $customer->id }}'>
                                        <i class='bx bx-trash me-1 icon-danger'></i> Delete this Customer
                                    </a>
                                    @if($consignment->contains($customer->id))

                                    <button type="button" class="btn dropdown-item text-dark deleteconsignment" id="deleteconsignment" name="deleteconsignment" data-id="{{ $customer->id }}">
                                        <i class='bx bx-check-circle'></i> Remove Consignment Location
                                    </button>
                                    @else
                                    <button type="button" class="btn dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#ConsignmentModel">
                                        <i class='bx bx-check-circle'></i> Setup as Consignment Location
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 mt-3">
                    <div class="card">
                        <h5 class="card-header">Sales / Accounting Info:</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless m-0">
                                    <tbody>
                                        @if($customer->sales_person)
                                            <tr>
                                                <th class="text-end">Primary Sales Person:</th>
                                                <td class="text-start">{{ $customer->sales_person->full_name }}</td>
                                            </tr>
                                        @endif
                                        @if($customer->secondary_sales_person)
                                            <tr>
                                                <th class="text-end">Secondary Sales Person:</th>
                                                <td class="text-start">{{ $customer->secondary_sales_person->full_name }}</td>
                                            </tr>
                                        @endif
                                        @if($customer->created_at)
                                            <tr>
                                                <th class="text-end">Since:</th>
                                                <td class="text-start">{{ $customer->created_at->format('M d, Y')}} ( {{ $customer->created_at->diffInDays(now()) }} Days)</td>
                                            </tr>
                                        @endif
                                        @if($customer->tax_exempt_reason)
                                            <tr>
                                                <th class="text-end">Tax Exempt Reason:</th>
                                                <td class="text-start">{{ $customer->tax_exempt_reason->reason }}</td>
                                            </tr>
                                        @endif
                                        @if($customer->exempt_certificate_no)
                                            <tr>
                                                <th class="text-end">Exempt Certificate #:</th>
                                                <td class="text-start">{{ $customer->exempt_certificate_no }}</td>
                                            </tr>
                                        @endif
                                        @if($customer->exempt_expiry_date)
                                        @php
                                            $expiryDate = \Carbon\Carbon::parse($customer->exempt_expiry_date);
                                        @endphp
                                        <tr>
                                            <th class="text-end">Exempt Expiry Date:</th>
                                            <td class="text-start">{{ $expiryDate->format('M d, Y') }}  ({{ $expiryDate->diffInDays(now()) }} Days to Go)</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-7 mt-3">
                    <div class="card mb-6">
                        <h5 class="card-header">Accounting Info:</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless m-0">
                                    <tbody>
                                        <tr>
                                            @if($customer->apply_finance_charge !== null)
                                                <th class="text-left">Finance Charge:</th>
                                                <td class="text-start">{{ $customer->apply_finance_charge == 1 ? 'YES' : '' }}</td>
                                            @endif
                                            @if($customer->preferred_document_id)
                                                <th class="text-left">Way of sending documents:</th>
                                                <td class="text-start">{{ $customer->preferred_document_id }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th class="text-left">Currency:</th>
                                            <td class="text-start">USD</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-6 mt-3">
                        <div class="card-body">
                            <div class="row p-sm-3 p-0">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                    @if($customer->delivery_instructions)
                                    <p class="mb-1"><strong>Special / Delivery Instructions</strong>: </p>
                                    <p class="mb-1">{{ $customer->delivery_instructions }} </p>
                                    @endif
                                    @if($customer->internal_notes)
                                        <p class="mb-1"><strong>Internal Notes</strong>: </p>
                                        <p class="mb-1">{{ $customer->internal_notes }} </p>
                                    @endif
                                    </div>
                                    <div class="col-4">
                                        @if($customer->delivery_instructions)
                                        <p class="mb-1"><span class="text-dark fw-bold">Parent Location </span>:</p>
                                        <p class="mb-1">{{ $customer->parent_location->company_name ?? '' }}</p>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 mt-3">
                    <div class="card mb-6">
                        <h5 class="card-header">Customer Balance:</h5>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Label</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Current:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>1 - 30:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>31 - 60:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>61 - 150:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Over 150:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Receivable Balance:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Open Credits:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Unapplied Receipts:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>AR Balance</b>:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Open Orders:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>PickTickets / PackingLists:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Customer Deposits:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Net AR</b>:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Limit:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Available Credit Limit</b>:</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Average Days to Pay</b>:</td>
                                        <td><a href="#">Click Here</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @include('customer.partials.__image_preview')
            </div>
            <div class="row">
                <div class="col-12 order-0 order-md-1">
                    <!-- Navigation -->
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between mb-3 pe-md-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item me-3">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#contact">
                                        <i class="bx bx-phone me-2"></i>
                                        <span class="align-middle">Contacts</span>
                                    </button>
                                </li>
                                <li class="nav-item me-3">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bin_type">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">Bin Type</span>
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
                                         <!-- Compare Tab -->
                                         @include('customer.contact.__contacts')
                                         <!-- Compare Tab -->
                                         @include('customer.bin_type.__bin_types')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('consignment.__model')
@endsection
@section('scripts')
@include('consignment.__script')
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#customer_image').on('change', function() {
                var formData = new FormData($('#showCustomerForm')[0]);
                var imageUrl = "{{ route('customers.upload') }}";
                $.ajax({
                    url: imageUrl, // Your route to handle image upload
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == "success") {
                            showToast('success', response.msg);
                        }
                    },
                    error: function(xhr) {

                    }
                });
            });

            $('#customer_image').on('change', function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewImage').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            });

            document.addEventListener("click",function (e){
                if(e.target.classList.contains("previewImage")){
                    const src = e.target.getAttribute("src");
                    document.querySelector(".customer_modal_img").src = src;
                    const myModal = new bootstrap.Modal(document.getElementById('customer_popup'));
                    myModal.show();
                }
            });

        });

    </script>
    @include('customer.contact.__script')
    @include('customer.bin_type.__scripts')
@endsection
