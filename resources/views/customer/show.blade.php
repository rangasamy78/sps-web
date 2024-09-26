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
                        <h5 class="card-header">{{ $customer->customer_name  }} ( {{ $customer->customer_code }})</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <form id="showCustomerForm" name="showCustomerForm" class="form-horizontal" enctype="multipart/form-data">
                                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $customer->id }}">
                                        <input type="file" class="form-control" id="customer_image" name="customer_image">
                                        @if($customer->customer_image)
                                            {{-- <img id="previewImage" class="previewImage" src="{{ asset('storage/app/public/'.$customer->customer_image)}}" alt="Image Preview" width="100" height="100" style="margin-top: 15px;border: 1px solid;border-radius: 50px;margin-left: 38px;"> --}}
                                            <img id="previewImage" class="img-fluid rounded mb-4 previewImage" src="{{ asset('storage/app/public/'.$customer->customer_image)}}" height="150" width="150" alt="User avatar" style="margin-top: 10px;margin-left: 20px;">
                                            @else
                                            <img id="previewImage" class="img-fluid rounded mb-4 previewImage" src="#" height="150" width="150" alt="User avatar" style="display:none;margin-top: 10px;margin-left: 20px;">
                                            {{-- <img id="previewImage" class="previewImage" src="" alt="Image Preview" width="100" height="100" style="display:none; margin-top: 15px;border: 1px solid;border-radius: 50px;margin-left: 38px;"> --}}
                                        @endif
                                    </form>
                                </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><strong>Default Price List </strong>:</p>
                                                <p class="mb-1">{{ isset($customer->price_list_label) ? $customer->price_list_label->price_code . '-' . $customer->price_list_label->price_label : '' }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><strong>Parent Location </strong>:</p>
                                                <p class="mb-1">{{ $customer->parent_location->company_name ?? '' }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><strong>Type </strong>:</p>
                                                <p class="mb-1">{{ $customer->customer_type->customer_type_name ?? '' }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><strong># Days for Hold </strong>:</p>
                                                <p class="mb-1">{{ $customer->hold_days . " Days" }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><strong>Payment Terms </strong>:</p>
                                                <p class="mb-1">{{ $customer->delivery_instructions }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><strong>Sales Tax (Tax Exempt) </strong>:</p>
                                                <p class="mb-1">{{ $customer->delivery_instructions }}</p>
                                            @endif
                                        </div>
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
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#account_payable">
                                        <i class="bx bx-wallet me-2"></i>
                                        <span class="align-middle">Files</span>
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
                                        @include('customer.contact.__contacts')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
@endsection
