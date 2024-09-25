@extends('layouts.admin')

@section('title', 'Add Customer')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home /</span><span> Add Customer</span></h4>
            <div class="app-ecommerce">
                {!! Form::open(['id' => 'customerForm', 'name' => 'customerForm', 'method' => 'POST', 'route' => 'customers.store', 'class' => 'form-horizontal']) !!}
                    @csrf
                    @include('customers.partials._customer_form')
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                            {!! Form::reset('Reset', ['class' => 'btn btn-secondary']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
                <div class="content-backdrop fade"></div>
            </div>
        @endsection
        @section('scripts')

            <script type="text/javascript">
                $(function() {
                    $('#customer_type_id').select2({
                        placeholder: 'Select Customer Type',
                        dropdownParent: $('#customer_type_id').parent()
                    });

                    $('#parent_customer_id').select2({
                        placeholder: 'Select Parent Customer',
                        dropdownParent: $('#parent_customer_id').parent()
                    });

                    $('#referred_by_id').select2({
                        placeholder: 'Select Referred By',
                        dropdownParent: $('#referred_by_id').parent()
                    });

                    $('#country_id').select2({
                        placeholder: 'Select Country',
                        dropdownParent: $('#country_id').parent()
                    });

                    $('#shipping_country_id').select2({
                        placeholder: 'Select Shipping Country',
                        dropdownParent: $('#shipping_country_id').parent()
                    });

                    $('#parent_location_id').select2({
                        placeholder: 'Select Parent Location',
                        dropdownParent: $('#parent_location_id').parent()
                    });

                    $('#route_location_id').select2({
                        placeholder: 'Select Route Location',
                        dropdownParent: $('#route_location_id').parent()
                    });

                    $('#preferred_document_id').select2({
                        placeholder: 'Select Preferred Document',
                        dropdownParent: $('#preferred_document_id').parent()
                    });

                    $('#sales_person_id').select2({
                        placeholder: 'Select Sales Person',
                        dropdownParent: $('#sales_person_id').parent()
                    });

                    $('#secondary_sales_person_id').select2({
                        placeholder: 'Select Secondary Sales Person',
                        dropdownParent: $('#secondary_sales_person_id').parent()
                    });

                    $('#price_list_label_id').select2({
                        placeholder: 'Select Price List Label',
                        dropdownParent: $('#price_list_label_id').parent()
                    });

                    $('#tax_exempt_reason_id').select2({
                        placeholder: 'Select Tax Exempt Reason',
                        dropdownParent: $('#tax_exempt_reason_id').parent()
                    });

                    $('#sales_tax_id').select2({
                        placeholder: 'Select Sales Tax',
                        dropdownParent: $('#sales_tax_id').parent()
                    });

                    $('#payment_terms_id').select2({
                        placeholder: 'Select Payment Terms',
                        dropdownParent: $('#payment_terms_id').parent()
                    });

                    $('#about_us_option_id').select2({
                        placeholder: 'Select How You Heard About Us',
                        dropdownParent: $('#about_us_option_id').parent()
                    });

                    $('#project_type_id').select2({
                        placeholder: 'Select Project Type',
                        dropdownParent: $('#project_type_id').parent()
                    });

                    $('#end_use_segment_id').select2({
                        placeholder: 'Select End Use Segment',
                        dropdownParent: $('#end_use_segment_id').parent()
                    });

                    $('#default_fulfillment_method_id').select2({
                        placeholder: 'Select Default Fulfillment Method',
                        dropdownParent: $('#default_fulfillment_method_id').parent()
                    });


                    $('#same_as_address').change(function() {
                        toggleShippingAddress(this);  // Pass the checkbox object to the function
                    });

                    function toggleShippingAddress(obj) {
                        var isChecked = $(obj).is(':checked');
                        $('#shipping_address').val(isChecked ? $('#address').val() : '');
                        $('#shipping_address_2').val(isChecked ? $('#address_2').val() : '');
                        $('#shipping_city').val(isChecked ? $('#city').val() : '');
                        $('#shipping_state').val(isChecked ? $('#state').val() : '');
                        $('#shipping_zip').val(isChecked ? $('#zip').val() : '');
                        $('#shipping_country_id').val(isChecked ? $('#country_id').val() : null).trigger('change');
                        if (isChecked) {
                            $('#shipping_zip').trigger('blur');
                        }
                        $('#shipping_county').val(isChecked ? $('#county').val() : '');
                    }

                    // On change event of Select2 dropdown
                    $('#parent_customer_id').change(function() {
                        var billingAddressUrl = "{{ route('customers.billing-address') }}";
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to fill the billing address fields with the selected customer's address?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var selectedCustomerId = $(this).val();
                                $.ajax({
                                    url: billingAddressUrl,
                                    method: 'GET',
                                    data: { id: selectedCustomerId },
                                    success: function(response) {
                                        $('#address').val(response.address);
                                        $('#address_2').val(response.address_2);
                                        $('#city').val(response.city);
                                        $('#state').val(response.state);
                                        $('#zip').val(response.zip);
                                        $('#country_id').val(response.country_id).trigger('change');
                                        $('#county').val(response.county);
                                    },
                                    error: function() {
                                        Swal.fire('Error', 'Failed to fetch customer address', 'error');
                                    }
                                });
                            }
                        });
                    });

                    $('#is_allow_login').change(function() {
                        if ($(this).is(':checked')) {
                            $('#username, #password').closest('.form-group').show();
                        } else {
                            $('#username, #password').closest('.form-group').hide();
                        }
                    });

                    // Trigger the change event on page load if checkbox is already checked
                    $('#is_allow_login').trigger('change');

                });
            </script>
        @endsection
