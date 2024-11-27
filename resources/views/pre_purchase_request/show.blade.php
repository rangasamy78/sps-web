@extends('layouts.admin')

@section('title', 'Pre Purchase Request')
@section('styles')
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><a href="{{ route('pre_purchase_requests.index') }}"
                    class="text-decoration-none text-dark "><span class="text-muted fw-light">Pre Purchase Request
                        /</span><span> Show Pre Purchase Request</span></a></h4>
            <div class="app-ecommerce">
                <div class="row">
                    <!-- first column -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0 fw-bold">
                                    <span class="text-dark fw-bold">Pre Purchase Requests#</span>
                                    {{ $pre_purchase_request->transaction_number }}
                                </h4>
                                <p class="fw-bold">
                                    {{ toDbDateDisplay($pre_purchase_request->pre_purchase_date ?? '') }}
                                </p>
                                <div class="d-flex align-items-center"> <!-- Container for buttons -->
                                    <a href="{{ route('pre_purchase_requests.edit', $pre_purchase_request->id) }}"
                                        data-id="{{ $pre_purchase_request->id }}"
                                        class="btn btn-primary rounded-circle editbtn" data-bs-toggle="tooltip"
                                        data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark"
                                        title="Edit pre_purchase_request"
                                        style="width: 35px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fi fi-rr-pencil fs-4" style="font-size: 18px;"></i>
                                    </a>

                                    <div class='dropdown ms-2'>
                                        <button type='button'
                                            class='btn p-0 dropdown-toggle hide-arrow btn-primary rounded-circle'
                                            data-bs-toggle='dropdown' aria-expanded="false"
                                            style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class='fi fi-rr-plus fs-4' data-bs-toggle="tooltip" data-bs-offset="0,8"
                                                data-bs-placement="right" data-bs-custom-class="tooltip-dark"
                                                title="Reports"></i> <!-- Icon inside the button -->
                                        </button>
                                        <div class='dropdown-menu'>
                                            <a class='fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip"
                                                data-bs-offset="0,8" data-bs-placement="right"
                                                data-bs-custom-class="tooltip-dark" _title="Undo Acceptancy">
                                                <i class='bx bxs-calculator'></i> Undo Acceptancy
                                            </a>
                                            <a class='fw-bold text-dark' href='{{ route('pre_purchase_requests.index') }}'
                                                data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right"
                                                data-bs-custom-class="tooltip-dark" _title="List All Pre-Purchase Requests">
                                                <i class='bx bx-history'></i> List All Pre-Purchase Requests
                                            </a>
                                            <a class='fw-bold text-dark' href='javascript:void(0);' data-bs-toggle="tooltip"
                                                data-bs-offset="0,8" data-bs-placement="right"
                                                data-bs-custom-class="tooltip-dark"
                                                _title="Delete this Pre-Purchase Request   ">
                                                <i class='bx bx-history'></i> Delete this Pre-Purchase Request
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-md-6 col-lg-4 ">
                                        <h5><span class="text-dark fw-bold">Supplier</span>:</h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="supplier_name"><span
                                                        class="text-dark fw-bold">{{ $pre_purchase_request->supplier->supplier_name ?? '' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label
                                                    for="remit_address"><span>{{ $pre_purchase_request->supplier->remit_address ?? '' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label
                                                    for="remit_suite"><span>{{ $pre_purchase_request->supplier->remit_suite ?? '' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="remit_city"><span>{{ $pre_purchase_request->supplier->remit_city ?? '' }}
                                                        {{ $pre_purchase_request->supplier->remit_state ?? '' }}
                                                        {{ $pre_purchase_request->supplier->remit_zip ?? '' }}</span></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label
                                                    for="country_name"><span>{{ $pre_purchase_request->supplier->remit_country->country_name ?? '' }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 ">
                                        <h5><span class="text-dark fw-bold">Required Ship Date</span></h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="supplier_name"><span
                                                        class="text-dark">{{ toDbDateDisplay($pre_purchase_request->required_ship_date ?? '') }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 ">
                                        <h5><span class="text-dark fw-bold">Requested By</span></h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="supplier_name"><span
                                                        class="text-dark">{{ $pre_purchase_request->user->full_name ?? '' }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /first column -->
                </div>
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Add Internal Notes : </span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div id="internalData"></div>
                                        <div class="mt-2">
                                            <span class="text-danger error-text internal_notes_error"></span>
                                            <form id="internalNoteForm" name="internalNoteForm" method="POST"
                                                class="form-horizontal">
                                                <input type="hidden" name="supplier_id" id="supplier_id"
                                                    value="{{ $pre_purchase_request->supplier->id }}">
                                                <input type="hidden" name="internal_note_id" id="internal_note_id">
                                                <input type="hidden" name="pre_purchase_request_id"
                                                    id="pre_purchase_request_id" value="{{ $pre_purchase_request->id }}">
                                                <input type="hidden" name="user_id" id="user_id"
                                                    value="{{ $pre_purchase_request->user->id }}">
                                                <textarea class="form-control" name="internal_notes" id="internal_notes" cols="50" rows="2"></textarea>
                                                <button type="submit" class="btn btn-primary mt-2"
                                                    id="internal_save_data" name="internal_save_data">Save</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Pre purchase Term : </span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <textarea name="pre_purchase_term" id="pre_purchase_term" class="form-control" cols="50" rows="5">{{ $pre_purchase_request->terms ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-tile mb-0"><span class="text-dark fw-bold">Supplier Requests : </span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <table class="datatables-basic table tables-basic border-top table-striped"
                                            id="prePurchaseRequestSupplierRequest">
                                            <thead class="table-header-bold">
                                                <tr class="odd gradeX">
                                                    <th>Sl.No</th>
                                                    <th>Requested Date</th>
                                                    <th>Requests Sent</th>
                                                    <th>Supplier</th>
                                                    <th>Response Date</th>
                                                    <th>Status</th>
                                                    <th>Compare</th>
                                                    <th>Request</th>
                                                    <th>Response</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 order-0 order-md-1">
                        <div class="col-12 mx-auto card-separator">
                            <div class="d-flex justify-content-between pe-md-3">
                                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                    <li class="nav-item me-3">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#compEvent">
                                            <i class="bx bx-phone me-2"></i>
                                            <span class="align-middle">Compare</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#product">
                                            <i class="bx bx-phone me-2"></i>
                                            <span class="align-middle">Products</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#files">
                                            <i class="bx bx-wallet me-2"></i>
                                            <span class="align-middle">Files</span>
                                        </button>
                                    </li>
                                    <li class="nav-item me-3">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#event">
                                            <i class="bx bx-credit-card me-2"></i>
                                            <span class="align-middle">CRM</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-4">
                            {{-- <div class="card-header">&nbsp;</div> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 pt-4 pt-md-0">
                                        <div class="tab-content p-0 pe-md-5 ps-md-3">
                                            <!-- Compare Tab -->
                                            @include('pre_purchase_request.partials.compare.compares', [
                                                'pre_purchase_request' => $pre_purchase_request,
                                            ])
                                            <!-- Product Tab -->
                                            @include('pre_purchase_request.partials.product.products', [
                                                'pre_purchase_request' => $pre_purchase_request,
                                            ])
                                            <!-- Files Tab -->
                                            @include('pre_purchase_request.partials.file.files', [
                                                'pre_purchase_request' => $pre_purchase_request,
                                            ])
                                            <!-- CRM Tab -->
                                            @include('pre_purchase_request.partials.events.events', [
                                                'pre_purchase_request' => $pre_purchase_request,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- app-ecommerce -->
        </div>
    </div>

    <div class="modal fade" id="showPrePurchaseRequestCompareModal" tabindex="-1" aria-labelledby="show-pre-purchase-request-compare-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="show-pre-purchase-request-compare-modal-label">Supplier Response for Prepurchase Request # {{ $pre_purchase_request->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @include('pre_purchase_request.partials.internal_notes.__scripts')
    @include('pre_purchase_request.partials.supplier_request.__scripts')
    @include('pre_purchase_request.partials.product.__scripts')
    @include('pre_purchase_request.partials.events.__scripts')
    @include('pre_purchase_request.partials.compare.__scripts')
    @include('pre_purchase_request.partials.file.__scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            function getCheckedValues(prePurId) {
                var checkedValues = [];
                $('#prePurchaseRequestSupplierRequest tbody .supplierCompare:checked').each(function() {
                    checkedValues.push($(this).val());
                });
                var checkedValuesString = checkedValues.join(',');
                console.log('Checked Values String: ', checkedValuesString);

                if (checkedValuesString) {
                    var supplierUrl = "{{ route('get_supplier_compare_details') }}";
                    $('#prePurchaseRequestCompare tbody').empty();

                    $.ajax({
                        url: supplierUrl,
                        method: 'GET',
                        data: {
                            ids: checkedValuesString,
                            pre_purchase_request_id: prePurId
                        },
                        dataType: 'json',
                        success: function(products) {
                            $.each(products, function(index, product) {
                                const displayValue = (field, defaultValue = 'N/A') => field ?? defaultValue;
                                const fullAddress = `
                                    ${displayValue(product.qty)} * ${displayValue(product.unit_price)}<br>
                                    Total : ${displayValue(product.total_price)}<br>
                                `;
                                const productDetails = `
                                    ${displayValue(product.product_name)} <br/> ${displayValue(product.generic_name)}<br>
                                `;
                                $('#prePurchaseRequestCompare tbody').append(`
                                    <tr>
                                        <td>${displayValue(product.supplier_name)}</td>
                                        <td>${displayValue(product.required_ship_date)}</td>
                                        <td>${displayValue(product.payment_label)}</td>
                                        <td>${displayValue(product.shipment_term_name)}</td>
                                        <td>${displayValue(product.generic_name)}</td>
                                        <td>${productDetails}</td>
                                        <td>${fullAddress}</td>
                                        <td>
                                            <div>
                                                <a class='showComparebtn text-warning' href='javascript:void(0);' data-id='${product.pre_purchase_request_id}' data-supplier-id='${product.supplier_id}'><i class='bx bx-show me-1 icon-warning'></i></a>
                                                <a class='statusComparebtn text-success' href='javascript:void(0);' data-id='${product.product_id}'> <i class='bx bx-edit-alt me-1 icon-success'></i> </a>
                                                ${product.reject_status == 0 ? `
                                                    <a class='statusRejectbtn text-danger' href='javascript:void(0);' data-id='${product.product_id}'><i class='bx bx-trash me-1 icon-danger'></i></a>
                                                ` : ''}
                                            </div>
                                        </td>
                                    </tr>
                                `);
                            });
                        },
                        error: function() {
                            alert('Error fetching products');
                        }
                    });
                } else {
                    $('#prePurchaseRequestCompare tbody').empty();
                }
            }

            $('body').on('click', '.supplierCompare', function() {
                var prePurId = $(this).data('id');
                getCheckedValues(prePurId);
            });

            $('#prePurchaseRequestSupplierRequest').on('draw.dt', function() {
                var prePurId = $('.supplierCompare:checked').data('id');
                getCheckedValues(prePurId);
            });

            $('body').on('click', '.showComparebtn', function() {
                var request_id = $(this).data('id');
                var supplier_id = $(this).data('supplier-id');
                var compareResponseUrl = "{{ route('pre_purchase_compare.response') }}";
                $.ajax({
                    url: compareResponseUrl,
                    type: 'POST',
                    data: {
                            pre_purchase_request_id : request_id,
                            supplier_id: supplier_id
                        },
                    success: function(response) {
                        console.log(response);
                        $('#modalContent').html(response.html);
                        $('#showPrePurchaseRequestCompareModal').modal('show');
                    },
                    error: function() {
                        alert('Error loading modal content');
                    }
                });
            });

            $('body').on('click', '.statusComparebtn', function() {
                var productId = $(this).data('id');
                if (confirm('Are you sure you want to update the product status?')) {
                    $.ajax({
                        url: '{{ route("pre_purchase_compare.update.status") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: productId,
                            status: 1
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                showToast('success', response.msg);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('AJAX Error: ' + error);
                        }
                    });
                }
            });

            $('body').on('click', '.statusComparebtn', function() {
                var productId = $(this).data('id');
                if (confirm('Are you sure you want to update the product status?')) {
                    $.ajax({
                        url: '{{ route("pre_purchase_compare.update.status") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: productId,
                            status: 1
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                showToast('success', response.msg);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('AJAX Error: ' + error);
                        }
                    });
                }
            });

            $('body').on('click', '.statusRejectbtn', function() {
                var productId = $(this).data('id');
                if (confirm('Are you sure you want to reject this supplier?')) {
                    $.ajax({
                        url: '{{ route("pre_purchase_compare.reject.status") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: productId,
                            reject_status: 1
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                showToast('success', response.msg);
                                $(this).hide();
                                table.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('AJAX Error: ' + error);
                        }
                    });
                }
            });

        });
    </script>
@endsection
