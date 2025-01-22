<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#formAddNewCustomer input, #formAddNewCustomer select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });
        $('#saveCustomer').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('customers.store') }}";
            var type = "POST";
            var data = $('#formAddNewCustomer').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#formAddNewCustomer').trigger("reset");
                        $('#customer_type_id, #parent_customer_id, #referred_by_id,#parent_location_id,#sales_person_id,#secondary_sales_person_id,#payment_terms_id,#sales_tax_id,#price_list_label_id').val(null).trigger('change');
                        $('#AddNewCustomer').modal('hide');
                        sending(button, true);
                        table_customer_list.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#sameAsBillTo').on('change', function() {
            if ($(this).is(':checked')) {
                $('#formAddNewCustomer #shipping_address').val($('#formAddNewCustomer #address').val());
                $('#formAddNewCustomer #shipping_address_2').val($('#formAddNewCustomer #address_2').val());
                $('#formAddNewCustomer #shipping_city').val($('#formAddNewCustomer #city').val());
                $('#formAddNewCustomer #shipping_state').val($('#formAddNewCustomer #state').val());
                $('#formAddNewCustomer #shipping_zip').val($('#formAddNewCustomer #zip').val());
            } else {
                $('#formAddNewCustomer #shipping_address').val('');
                $('#formAddNewCustomer #shipping_address_2').val('');
                $('#formAddNewCustomer #shipping_city').val('');
                $('#formAddNewCustomer #shipping_state').val('');
                $('#formAddNewCustomer #shipping_zip').val('');
            }
        });


        $('#formAddNewAssociate input, #formAddNewAssociate select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#saveAssociate').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('associates.store') }}";
            var type = "POST";
            var data = $('#formAddNewAssociate').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#formAddNewAssociate').trigger("reset");
                        $('#associate_type_id,#country_id, #location_id, #primary_sales_id').val(null).trigger('change');
                        $('#AddNewAssociate').modal('hide');
                        sending(button, true);
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        //pop up customer list
        $(' #customerNameFilter,#customerCodeFilter,#contactFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_customer_list.draw();
        });
        var table_customer_list = $('#customerListTable').DataTable({
            // scrollX: true, // Enable horizontal scrolling
            // paging: true,
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('opportunities.customer_list') }}",
                data: function(d) {
                    d.customerName = $('#customerNameFilter').val();
                    d.customerCode = $('#customerCodeFilter').val();
                    d.contact = $('#contactFilter').val();
                }
            },
            columns: [{
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'customer_code',
                    name: 'customer_code'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
            ],
            rowCallback: function(row, data, index) {
                $(row).on('click', function() {
                    $('#billing_customer_id').val(data.id);
                    $('#billing_customer_name').val(data.customer_name);
                    $('#address').val(data.address);
                    $('#suite').val(data.address_2);
                    $('#city').val(data.city);
                    $('#zip').val(data.zip);
                    $('#country').val(data.country_id);
                    $('#phone').val(data.phone);
                    $('#fax').val(data.fax);
                    $('#mobile').val(data.mobile);
                    $('#email').val(data.email);
                    $('#price_level_label_id').val(data.price_list_label_id).trigger('change');
                    $('#primary_sales_person_id').val(data.sales_person_id).trigger('change');
                    $('#secondary_sales_person_id').val(data.secondary_sales_person_id);
                    $('#sales_tax_id').val(data.sales_tax_id).trigger('change');
                    $('#searchCustomer').modal('hide');
                });
            },
        });

        //associate pop up
        $(' #nameFilter,#codeFilter,#phoneFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_associate_list.draw();
        });
        let currentNameField = null;
        let currentIdField = null;

        // Handle search icon click to store the correct input fields
        $('.input-group-text').on('click', function() {
            const container = $(this).closest('.d-flex');
            currentNameField = container.find('input[type="text"]');
            currentIdField = container.find('input[type="hidden"]');
        });

        // DataTable initialization
        var table_associate_list = $('#associateListTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('opportunities.associate_list') }}",
                data: function(d) {
                    d.associateName = $('#nameFilter').val();
                    d.associateCode = $('#codeFilter').val();
                    d.contact = $('#phoneFilter').val();
                }
            },
            columns: [{
                    data: 'associate_name',
                    name: 'associate_name'
                },
                {
                    data: 'associate_code',
                    name: 'associate_code'
                },
                {
                    data: 'primary_phone',
                    name: 'primary_phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
            ],
            rowCallback: function(row, data, index) {
                $(row).attr('data-associate-id', data.id); // Store associate ID in the row attribute

                // Handle row click to insert data into the correct fields
                $(row).on('click', function() {
                    if (currentNameField && currentIdField) {
                        currentNameField.val(data.associate_name); // Set the name in the text field
                        currentIdField.val(data.id); // Set the ID in the hidden field

                        // Close the modal
                        $('#searchAssociate').modal('hide');
                    }
                });
            },
        });

        //  clear button
        $('.clear-associate').on('click', function(event) {
            event.preventDefault(); // Prevent any default action, just in case
            const target = $(this).data('target');
            $(`#${target}_id`).val('');
            $(`#${target}_name`).val('');
        });

        //pop up ship to
        $(' #shipToNameFilter,#shipToCodeFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_ship_to_list.draw();
        });

        $('#ship_to,#ship_to_icon').on('click', function() {
            let customer_id = $('#billing_customer_id').val();
            if (customer_id) {
                $('#searchShipTo').modal('show');
                if ($.fn.DataTable.isDataTable('#shipToListTable')) {
                    table_ship_to_list.ajax.url(
                        "{{ route('opportunities.ship_to_list', ':id') }}".replace(':id', customer_id)
                    ).load();
                } else {
                    table_ship_to_list = $('#shipToListTable').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        searching: false,
                        ajax: {
                            url: "{{ route('opportunities.ship_to_list', ':id') }}".replace(':id', customer_id),
                            data: function(d) {
                                d.name = $('#shipToNameFilter').val();
                                d.code = $('#shipToCodeFilter').val();
                            }
                        },
                        columns: [{
                                data: 'customer_name',
                                name: 'customer_name'
                            },
                            {
                                data: 'customer_code',
                                name: 'customer_code'
                            },
                            {
                                data: 'address',
                                name: 'address'
                            }
                        ],
                        rowCallback: function(row, data, index) {
                            $(row).on('click', function() {
                                $('#ship_to_id').val(data.id);
                                $('#ship_to').val(data.customer_name);
                                $('#ship_to_name').val(data.customer_name_1);
                                $('#sales_tax_id').val(data.tax_code_id);

                                // Close the modal
                                $('#searchShipTo').modal('hide');
                            });
                        }
                    });
                }
            } else {
                alert('First select billing customer');
            }
        });

        $('#cancelButton').click(function() {
            window.location.href = "{{ route('opportunities.index') }}";
        });

        // Function to copy the billing customer name to a target field
        function copyBillingCustomer(target) {
            let billingCustomer = $('#billing_customer_name').val();
            $(target).val(billingCustomer || '');
        }

        // Function to concatenate lot and sub-division with the billing customer name
        function setCustomerWithLotAndDivision(lotSelector, subDivisionSelector, target) {
            let billingCustomer = $('#billing_customer_name').val();
            let lot = $(lotSelector).val();
            let subDivision = $(subDivisionSelector).val();
            let formattedCustomer = billingCustomer;
            if (lot || subDivision) {
                formattedCustomer += ` (${lot || ''}/${subDivision || ''})`;
            }
            $(target).val(formattedCustomer);
        }

        // Event listeners for pick and delivery operations
        $('#copy_bill_to').click(function() {
            copyBillingCustomer('#ship_to_job_name');
        });
        $('#copy_lot_division').click(function() {
            setCustomerWithLotAndDivision('#ship_to_lot', '#ship_to_sub_division', '#ship_to_job_name');
        });
        $('#ship_to_copy_bill').click(function() {
            const fields = [{
                    from: 'billing_customer_id',
                    to: 'ship_to_id'
                },
                {
                    from: 'billing_customer_name',
                    to: 'ship_to'
                },
                {
                    from: 'billing_customer_name',
                    to: 'ship_to_name'
                },
                {
                    from: 'address',
                    to: 'ship_to_address'
                },
                {
                    from: 'suite',
                    to: 'ship_to_suite'
                },
                {
                    from: 'city',
                    to: 'ship_to_city'
                },
                {
                    from: 'state',
                    to: 'ship_to_state'
                },
                {
                    from: 'zip',
                    to: 'ship_to_zip'
                },
                {
                    from: 'country',
                    to: 'ship_to_country_id'
                },
                {
                    from: 'phone',
                    to: 'ship_to_phone'
                },
                {
                    from: 'fax',
                    to: 'ship_to_fax'
                },
                {
                    from: 'mobile',
                    to: 'ship_to_mobile'
                },
                {
                    from: 'email',
                    to: 'ship_to_email'
                }
            ];

            // Loop through each field and copy the values
            fields.forEach(({
                from,
                to
            }) => {
                $(`#${to}`).val($(`#${from}`).val());
            });
        });

        //ship to fields hide and show
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-type');
                document.querySelectorAll('.conditional-fields').forEach(field => field.classList.add('d-none'));
                document.querySelector(`#${type}-fields`).classList.remove('d-none');
            });
        });

    });
</script>