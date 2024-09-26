<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#customerNameFilter,#customerTypeFilter,#addressNameFilter,#customerPhoneFilter,#locationNameFilter,#statusFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('customers.list') }}",
                data: function(d) {
                    d.customer_name = $('#customerNameFilter').val();
                    d.customer_type_id = $('#customerTypeFilter').val();
                    d.customer_address = $('#addressFilter').val();
                    d.customer_phone_search = $('#customerPhoneFilter').val();
                    d.location_id = $('#locationNameFilter').val();
                    d.status = $('#statusFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [
                {
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'customer_type_name',
                    name: 'customer_type_name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'parent_location_name',
                    name: 'parent_location_name'
                },
                {
                    data: 'sales_person_name',
                    name: 'sales_person_name'
                },
                {
                    data: 'price_list_label_name',
                    name: 'price_list_label_name'
                },
                {
                    data: 'sales_tax_name',
                    name: 'sales_tax_name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                // $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Customer</span>',
                className: 'create-new btn btn-primary',
                action: function (e, dt, node, config) {
                    // Redirect to Laravel route
                    window.location.href = "{{ route('customers.create') }}";
                }
            }],

        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = $('#id').val() ? "{{ route('customers.update', ':id') }}".replace(':id', $('#id').val()) : "{{ route('customers.store') }}";
            var type = $('#id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#customerForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        setTimeout(function() {
                            window.location.href = "{{ route('customers.index') }}"; // Redirection after 2 seconds (adjust if needed)
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

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

        $('#status_id').select2({
            placeholder: 'Select Status',
            dropdownParent: $('#status_id').parent()
        });

        $('#customerTypeFilter').select2({
            placeholder: 'Select Customer Type',
            dropdownParent: $('#customerTypeFilter').parent()
        });

        $('#locationNameFilter').select2({
            placeholder: 'Select Location',
            dropdownParent: $('#locationNameFilter').parent()
        });

        $('#statusFilter').select2({
            placeholder: 'Select Status',
            dropdownParent: $('#statusFilter').parent()
        });

        $('#same_as_address').change(function() {
            toggleShippingAddress(this);  // Pass the checkbox object to the function
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCustomer(id);
            });
        });

        function deleteCustomer(id) {
            var url = "{{ route('customers.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, table);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

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

        $(document).on('click', '.change_status', function() {
            var id = $(this).data('id');
            var button = $(this);
            var url = "{{ route('customers.update_status', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        if (response.update_status == 1) {
                            button.removeClass('btn-danger').addClass('btn-success').text('Active');
                        } else {
                            button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                        }
                        showToast('success', response.msg);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            });
        });

        // $('#is_allow_login').change(function() {
        //     if ($(this).is(':checked')) {
        //         $('#username, #password').closest('.form-group').show();
        //     } else {
        //         $('#username, #password').closest('.form-group').hide();
        //     }
        // });

        // // Trigger the change event on page load if checkbox is already checked
        // $('#is_allow_login').trigger('change');
     });
</script>
