<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#addNewHoldForm input, #addNewHoldForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#nextStepAddProductBtn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#hold_id').val() ? "{{ route('hold.holds.update', ':id') }}".replace(':id', $('#hold_id').val()) : "{{ route('hold.holds.store') }}";
            var type = $('#hold_id').val() ? "PUT" : "POST";
            var data = $('#hold_id').val() ? $('#updateHoldForm').serialize() : $('#addNewHoldForm').serialize();
            var id = $('#hold_id').val();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        var redirectUrl = id ?
                            "{{ route('hold.edit_product', ':id') }}".replace(':id', response.hold_id) :
                            "{{ route('hold.index_product', ':id') }}".replace(':id', response.hold_id);
                        $('#addNewHoldForm').trigger("reset");
                        sending(button, true);
                        showToast('success', response.msg);
                        window.location.href = redirectUrl;
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        //pop ups javascript code
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
                        table_associate_list.draw();
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
                    $('#bill_to_address').val(data.address);
                    $('#bill_to_suite').val(data.address_2);
                    $('#bill_to_city').val(data.city);
                    $('#bill_to_zip').val(data.zip);
                    $('#bill_to_country').val(data.country_id);
                    $('#bill_to_phone').val(data.phone);
                    $('#bill_to_fax').val(data.fax);
                    $('#bill_to_mobile').val(data.mobile);
                    $('#bill_to_email').val(data.email);
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
                $(row).attr('data-associate-id', data.id);
                $(row).on('click', function() {
                    if (currentNameField && currentIdField) {
                        currentNameField.val(data.associate_name);
                        currentIdField.val(data.id);
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


        $('#cancelButton').click(function() {
            window.location.href = "{{ route('opportunities.index') }}";
        });


        $('#copy_bill_to').click(function() {
            const fields = [{
                    from: 'billing_customer_name',
                    to: 'job_name'
                },
                {
                    from: 'bill_to_address',
                    to: 'address'
                },
                {
                    from: 'bill_to_suite',
                    to: 'suite'
                },
                {
                    from: 'bill_to_city',
                    to: 'city'
                },
                {
                    from: 'bill_to_state',
                    to: 'state'
                },
                {
                    from: 'bill_to_zip',
                    to: 'zip'
                },
                {
                    from: 'bill_to_country',
                    to: 'country_id'
                },
                {
                    from: 'bill_to_phone',
                    to: 'phone'
                },
                {
                    from: 'bill_to_fax',
                    to: 'fax'
                },
                {
                    from: 'bill_to_mobile',
                    to: 'mobile'
                },
                {
                    from: 'bill_to_email',
                    to: 'email'
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

        // //ship to fields hide and show
        // document.querySelectorAll('[data-bs-toggle="pill"]').forEach(button => {
        //     button.addEventListener('click', () => {
        //         const type = button.getAttribute('data-type');
        //         document.querySelectorAll('.conditional-fields').forEach(field => field.classList.add('d-none'));
        //         document.querySelector(`#${type}-fields`).classList.remove('d-none');
        //     });
        // });

    });
</script>