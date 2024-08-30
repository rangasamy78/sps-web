    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#createPaymentMethodTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ route('payment_methods.list') }}",
                    data: function(d) {
                        d.method_name_search = $('#methodNameFilter').val();
                        d.account_search = $('#linkedAccountFilter').val();
                        d.account_type_search = $('#accountTypeFilter').val();
                        sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                        d.order = [{
                            column: 1,
                            dir: sort
                        }];
                    }
                },
                columns: [{
                        data: null,
                        name: 'serial',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'payment_method_name',
                        name: 'payment_method_name',
                    },
                    {
                        data: 'linked_account_id',
                        name: 'linked_account_id',
                    },
                    {
                        data: 'account_type_id',
                        name: 'account_type_id',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                rowCallback: function(row, data, index) {
                    $('td:eq(0)', row).html(table.page.info().start + index + 1);
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Payment Method</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#paymentMethodModel',
                    },
                    action: function(e, dt, node, config) {
                        $('#savedata').html("Save Payment Method");
                        clearError();
                        $('#paymentMethodForm').trigger("reset");
                        $('#linked_account_id, #account_type_id').val('').trigger('change');
                        $('#modelHeading').html("Create New Payment Method");
                        $('#paymentMethodModel').modal('show');
                    }
                }],
            });

            function clearError() {
                $('#payment_method_id').val('');
                $('.payment_method_name_error').text('');
                $('.linked_account_id_error').text('');
                $('.account_type_id_error').text('');
                $('.is_transaction_required_error').text('');
            }

            $('#paymentMethodForm input, #paymentMethodForm select').on('keyup change', function() {
                var inputName = $(this).attr('name');
                $('.' + inputName + '_error').html('');
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                var button = $(this);
                sending(button);
                var url = $('#payment_method_id').val() ? "{{ route('payment_methods.update', ':id') }}".replace(':id', $('#payment_method_id').val()) : "{{ route('payment_methods.store') }}";
                var type = $('#payment_method_id').val() ? "PUT" : "POST";
                $.ajax({
                    url: url,
                    type: type,
                    data: $('#paymentMethodForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "success") {
                            $('#paymentMethodForm').trigger("reset");
                            $('#paymentMethodModel').modal('hide');
                            showToast('success', response.msg);
                            table.draw();
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                        sending(button, true);
                    }
                });
            });


            $('body').on('click', '.editbtn', function() {
                clearError();
                var id = $(this).data('id');
                $.get("{{ route('payment_methods.index') }}" + '/' + id + '/edit', function(data) {
                    $('#modelHeading').html("Update Payment Method");
                    $('#savedata').html("Update Payment Method");
                    $('#paymentMethodModel').modal('show');
                    $('#payment_method_id').val(data.id);
                    $('#payment_method_name').val(data.payment_method_name);
                    $('#linked_account_id').val(data.linked_account_id).trigger('change');
                    $('#account_type_id').val(data.account_type_id).trigger('change');
                    $('#is_transaction_required').prop('checked', false);
                    if (data.is_transaction_required === 1) {
                        $('#is_transaction_required').prop('checked', true);
                    }
                });
            });

            $('body').on('click', '.deletebtn', function() {
                var id = $(this).data('id');
                confirmDelete(id, function() {
                    deletePaymentMethod(id);
                });
            });

            function deletePaymentMethod(id) {
                var url = "{{ route('payment_methods.destroy', ':id') }}".replace(':id', id);
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
                        showError('Oops!', 'Failed to fetch data.');
                    }
                });
            }

            $('body').on('click', '.showbtn', function() {
                var id = $(this).data('id');
                $.get("{{ route('payment_methods.index') }}" + '/' + id, function(data) {
                    $('#showPaymentMethodModal').modal('show');
                    $('#showPaymentMethodForm #payment_method_name').val(data.payment_method_name);
                    $('#showPaymentMethodForm #linked_account_id').val(data.linked_account_id);
                    $('#showPaymentMethodForm #account_type_id').val(data.account_type_id);
                    $('#showPaymentMethodForm #is_transaction_required').prop('checked', false);
                    if (data.is_transaction_required === 1) {
                        $('#showPaymentMethodForm #is_transaction_required').prop('checked', true);
                    }
                });
            });

            $('#methodNameFilter, #linkedAccountFilter, #accountTypeFilter').on('keyup change', function(e) {
                e.preventDefault();
                table.draw();
            });
        });
    </script>
