@extends('layouts.admin')

@section('title', 'Send Multiple Pre-Purchase Requests')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Send Multiple Pre-Purchase Requests</span></h4>
            <div class="app-ecommerce">
                {!! Form::open([
                    'id' => 'supplierMultipleRequestForm',
                    'name' => 'supplierMultipleRequestForm',
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                ]) !!}
                @csrf
                    @include('pre_purchase_request.partials.supplier_request.partials.__multiple_supplier_form')
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        {!! Form::hidden('multiple_supplier_request_id', '') !!}
                        {!! Form::button('Save Multiple Supplier Requests', ['class' => 'btn btn-primary', 'id' => 'saveMultipleSupData', 'value' => 'create']) !!}
                        {!! Form::reset('Reset', ['class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('#supplier_id').on('change', function() {
        var supplierUrl = "{{ route('get_supplier_details') }}";
        var supplierId = $(this).val();
        $('#prePurchaseMultipleRequest tbody').empty();

        if (supplierId) {
            $.ajax({
                url: supplierUrl,
                method: 'GET',
                data: {
                    id: supplierId
                },
                dataType: 'json',
                success: function(products) {
                    $.each(products, function(index, product) {
                        const displayValue = (field, defaultValue = 'N/A') => field ?? defaultValue;
                        const fullAddress = `
                        ${displayValue(product.remit_address)}<br>
                        ${displayValue(product.remit_suite)}<br>
                        ${displayValue(product.remit_city)}, ${displayValue(product.remit_state)}, ${displayValue(product.remit_zip)}<br>
                        ${displayValue(product.remit_country ? product.remit_country.country_name : '')}
                    `;
                        $('#prePurchaseMultipleRequest tbody').append(`
                            <tr>
                                <td>${displayValue(product.supplier_name)}</td>
                                <td>${fullAddress}</td>
                                <td>${displayValue(product.shipment_term?.shipment_term_name)}</td>
                                <td>${displayValue(product.supplier_name)}</td>
                                <td>${displayValue(product.email).toLowerCase()}</td>
                                <td>
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][supplier_id]" value="${displayValue(product.id)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][supplier_address]" value="${displayValue(product.remit_address)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][supplier_suite]" value="${displayValue(product.remit_suite)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][supplier_city]" value="${displayValue(product.remit_city)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][supplier_state]" value="${displayValue(product.remit_state)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][supplier_zip]" value="${displayValue(product.remit_zip)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][supplier_country_id]" value="${displayValue(product.remit_country ? product.remit_country.id : '')}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][payment_term_id]" value="${displayValue(product.payment_terms_id)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][shipment_term_id]" value="${displayValue(product.shipment_term.id)}" class="form-control" />
                                    <input type="hidden" id="${index}" name="multiple_request[${index}][email]" value="${displayValue(product.email)}" class="form-control" />
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function() {
                    alert('Error fetching products');
                }
            });
        }
    });

    $('#saveMultipleSupData').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = "{{ route('pre_purchase.multiple.store') }}";
            var id  = $("#supplierMultipleRequestForm #pre_purchase_request_id").val();
            $.ajax({
                url: url,
                type: "POST",
                data: $('#supplierMultipleRequestForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        setTimeout(function() {
                            window.location.href = "{{ route('pre_purchase_requests.show', ':id') }}".replace(':id', id);
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    handleArrayAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
});
</script>
@endsection
