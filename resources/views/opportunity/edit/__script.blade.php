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
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#editCancelButton').click(function() {
            window.location.href = "{{ route('opportunities.index') }}";
        });

        document.getElementById('sameAsBillTo').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('shipping_address').value = document.getElementById('address').value;
                document.getElementById('shipping_address_2').value = document.getElementById('address_2').value;
                document.getElementById('shipping_city').value = document.getElementById('city').value;
                document.getElementById('shipping_state').value = document.getElementById('state').value;
                document.getElementById('shipping_zip').value = document.getElementById('zip').value;
            } else {
                document.getElementById('shipping_address').value = '';
                document.getElementById('shipping_address_2').value = '';
                document.getElementById('shipping_city').value = '';
                document.getElementById('shipping_state').value = '';
                document.getElementById('shipping_zip').value = '';
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
        let currentNameField = null; // Track the name input field
        let currentIdField = null; // Track the corresponding hidden ID input field

        // Handle search icon click to store the correct input fields
        $('.input-group-text').on('click', function() {
            const container = $(this).closest('.d-flex'); // Get the container of the clicked element
            currentNameField = container.find('input[type="text"]'); // Name field (readonly)
            currentIdField = container.find('input[type="hidden"]'); // Hidden ID field
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
            // Clear the ID and name fields dynamically
            $(`#${target}_id`).val('');
            $(`#${target}_name`).val('');
        });

        //pop up ship to
        $(' #shipToNameFilter,#shipToCodeFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_ship_to_list.draw();
        });
        $('#ship_to').click(function() {
            let customer_id = $('#billing_customer_id').val();
            if (customer_id) {
                // Check if DataTable is already initialized
                if ($.fn.DataTable.isDataTable('#shipToListTable')) {
                    // If already initialized, just clear and draw
                    table_ship_to_list.clear().draw();
                } else {
                    // Initialize DataTable
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

    });
</script>