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
                                        <a class='dropdown-item inactivebtn text-success change_status' data-id='{{ $customer->id }}'>
                                            <i class='bx bx-check-circle'></i> @if($customer->status == 0)Active Customer
                                            @else
                                            Inactive Customer
                                            @endif
                                        </a>

                                        <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='{{ $customer->id }}'>
                                            <i class='bx bx-trash me-1 icon-danger'></i> Delete this Customer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <form id="showCustomerForm" name="showCustomerForm" class="form-horizontal" enctype="multipart/form-data">
                                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $customer->id }}">
                                        <input type="file" class="form-control" id="customer_image" name="customer_image">
                                        @if(!empty($customer->customer_image))
                                            {{-- <img id="previewImage" class="previewImage" src="{{ asset('storage/app/public/'.$customer->customer_image)}}" alt="Image Preview" width="100" height="100" style="margin-top: 15px;border: 1px solid;border-radius: 50px;margin-left: 38px;"> --}}
                                            <img id="previewImage" class="img-fluid rounded mb-4 previewImage" src="{{ asset('storage/app/public/'.$customer->customer_image)}}" height="150" width="150" alt="User avatar" style="margin-top: 10px;margin-left: 20px;">
                                            @else
                                            <img id="previewImage" class="img-fluid rounded mb-4 previewImage" src="{{ asset('public/assets/img/branding/location-logo.png')}}" height="150" width="150" alt="User avatar" style="margin-top: 10px;margin-left: 20px;">
                                            {{-- <img id="previewImage" class="previewImage" src="" alt="Image Preview" width="100" height="100" style="display:none; margin-top: 15px;border: 1px solid;border-radius: 50px;margin-left: 38px;"> --}}
                                        @endif
                                        <button type="submit" class="btn btn-primary" id="btn-save" value="create" style="margin-left: 50px;">Upload</button>
                                    </form>
                                    <span class="text-danger error-text customer_image_error"></span>
                                </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><span class="text-dark fw-bold">Default Price List </span>:</p>
                                                <p class="mb-1">{{ isset($customer->price_list_label) ? $customer->price_list_label->price_code . '-' . $customer->price_list_label->price_label : '' }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><span class="text-dark fw-bold">Parent Location </span>:</p>
                                                <p class="mb-1">{{ $customer->parent_location->company_name ?? '' }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><span class="text-dark fw-bold">Type </span>:</p>
                                                <p class="mb-1">{{ $customer->customer_type->customer_type_name ?? '' }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><span class="text-dark fw-bold"># Days for Hold </span>:</p>
                                                <p class="mb-1">{{ $customer->hold_days . " Days" }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><span class="text-dark fw-bold">Payment Terms </span>:</p>
                                                <p class="mb-1">{{ $customer->delivery_instructions }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            @if($customer->delivery_instructions)
                                                <p class="mb-1"><span class="text-dark fw-bold">Sales Tax (Tax Exempt) </span>:</p>
                                                <p class="mb-1">{{ $customer->delivery_instructions }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-7 mt-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Contact : </span> {{ $customer->contact_name ?? '' }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                    <h6 class="pb-2"><span class="text-dark fw-bold">Bill To</span></h6>
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
                                    <h6 class="pb-2"><span class="text-dark fw-bold">Ship to</span></h6>
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
                    <div class="card mb-4">
                        <h5 class="card-header"><span class="text-dark fw-bold">Sales / Accounting Info</span> :</h5>
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
                    <div class="card mb-4">
                        <h5 class="card-header"><span class="text-dark fw-bold">Accounting Info</span>:</h5>
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
                </div>
                <div class="col-12 col-lg-5 mt-4">
                    <div class="card mb-4">
                        <h5 class="card-header"><span class="text-dark fw-bold">Customer Balance</span> :</h5>
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
                                        <td>{{ "$" . number_format($customer->credit_limit, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Available Credit Limit</b>:</td>
                                        <td>{{ "$" . number_format($customer->credit_limit, 2) }}</td>
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
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row p-sm-3 p-0">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                    @if($customer->delivery_instructions)
                                    <p class="mb-1"><span class="text-dark fw-bold">Special / Delivery Instructions</span>: </p>
                                    <p class="mb-1">{{ $customer->delivery_instructions }} </p>
                                    @endif
                                    @if($customer->internal_notes)
                                        <p class="mb-1"><span class="text-dark fw-bold">Internal Notes</span>: </p>
                                        <p class="mb-1">{{ $customer->internal_notes }} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('customer.partials.__image_preview')
            </div>
            <div class="row">
                <div class="col-12 order-0 order-md-1">
                    <!-- Navigation -->
                    <div class="col-12  mx-auto card-separator">
                        <div class="d-flex justify-content-between pe-md-3">
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
                                        <span class="align-middle text-dark fw-bold">Files</span>
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

            $(document).on('click', '.change_status', function() {
                var id = $(this).data('id');
                var button = $(this);
                var url = "{{ route('customers.update_status', ':id') }}";
                url = url.replace(':id', id);
                var currentUrl = window.location.href;
                var redirectUrl = currentUrl.replace(/\/\d+$/, '');
                redirectUrl += '/' + id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            var redirectUrl = getRedirectUrl(id);
                            setTimeout(function() {
                                window.location.href = redirectUrl; // Redirect after delay
                            }, 2000);
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                });
            });

            // $('#customer_image').on('change', function() {
            //     var formData = new FormData($('#showCustomerForm')[0]);
            //     var imageUrl = "{{ route('customers.upload') }}";
            //     $.ajax({
            //         url: imageUrl, // Your route to handle image upload
            //         type: 'POST',
            //         data: formData,
            //         contentType: false,
            //         processData: false,
            //         success: function(response) {
            //             if (response.status == "success") {
            //                 showToast('success', response.msg);
            //             }
            //         },
            //         error: function(xhr) {

            //         }
            //     });
            // });

            $('body').on('click', '#btn-save', function (e) {
                e.preventDefault();
                var button = $(this);
                sending(button);
                var imageUrl = "{{ route('customers.upload') }}";
                var formData = new FormData($('#showCustomerForm')[0]);
                $.ajax({
                    url: imageUrl,
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == "success") {
                            showToast('success', response.msg);
                            setTimeout(function() {
                                window.location.href =
                                "{{ route('customers.index') }}"; // Redirection after 2 seconds (adjust if needed)
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                        sending(button, true);
                    }
                });
            });

            $('#customer_image').on('change', function (e) {
                var file = this.files[0];
                if (file) {
                    var fileExtension = file.name.split('.').pop().toLowerCase();
                    var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    if (allowedExtensions.includes(fileExtension)) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $(".customer_image_error").html('');
                            $('#previewImage').attr('src', e.target.result).show();
                        }
                        reader.readAsDataURL(file); // Read the file as a data URL
                    } else {
                        alert('Please upload an image file (jpg, jpeg, png, gif).');
                        $('#customer_image').val(''); // Clear the file input
                        // $('#previewImage').hide(); // Hide the image preview
                    }
                }
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
