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


        var table_customer_list = $('#customerListTable').DataTable({
            // scrollX: true, // Enable horizontal scrolling
            // paging: true,
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('accounts.list') }}",
                data: function(d) {}
            },
            columns: [],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
                if (data.status === 'Inactive') {
                    $(row).addClass('table-danger');
                }
            },
        });

        $('#customerTable').on('click', 'tr', function() {
            let customerId = $(this).data('customer-id');
            $('#searchCustomer').modal('hide');

            if (customerId) {
                $.ajax({
                    url: "{{ route('customers.details', ':id') }}".replace(':id', customerId),
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        // Optional: Show a loading spinner
                        $('#loadingSpinner').show();
                    },
                    success: function(data) {
                        $('#billing_customer_id').val(data.customer_name);
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
                        // $('#bin_type').val(data.bin_type);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: ", error);
                        alert("An error occurred while fetching the customer details.");
                    },
                    complete: function() {
                        // Hide the loading spinner after the request completes
                        $('#loadingSpinner').hide();
                    }
                });
            } else {
                alert("Customer ID is not available.");
            }
        });


    });
</script>