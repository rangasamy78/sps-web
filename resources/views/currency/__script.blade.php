<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#currencyTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('currencies.list') }}",
                data: function(d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 0,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'currency_symbol',
                    name: 'currency_symbol'
                },
                {
                    data: 'currency_code',
                    name: 'currency_code'
                },
                {
                    data: 'currency_name',
                    name: 'currency_name'
                },

                {
                    data: 'currency_exchange_rate',
                    name: 'currency_exchange_rate'
                },
                {
                    data: 'formatted_date',
                    name: 'formatted_date',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },

            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            // displayLength: 7,
            // lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Currency</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#currencyModel',
                    'id': 'createCurrency',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#savedata').html("Save Currency");
                    clearError();
                    $('#currencyForm').trigger("reset");
                    $('#modelHeading').html("Create New Currency");
                    $('#currencyModel').modal('show');
                }
            }],
        });

        function clearError() {
            $('#currency_id').val('');
            $('.currency_code_error').text('');
            $('.currency_name_error').text('');
            $('.currency_symbol_error').text('');
            $('.currency_exchange_rate_error').text('');
        }


        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
                '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
                '30px');
        }, 300);

        $('#currencyForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#currency_id').val() ? "{{ route('currencies.update', ':id') }}".replace(':id', $('#currency_id').val()) : "{{ route('currencies.store') }}";
            var type = $('#currency_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#currencyForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#currencyForm').trigger("reset");
                        $('#currencyModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Currency Added Successfully!' : 'Currency Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function() {
            clearError();
            var id = $(this).data('id');
            $.get("{{ route('currencies.index') }}" + '/' + id + '/edit', function(data) {
                $(".name_error").html("");
                $('#modelHeading').html("Update Currency");
                $('#savedata').val("edit-currency");
                $('#savedata').html("Update Currency");
                $('#currencyModel').modal('show');
                $('#currency_id').val(data.id);
                $('#currency_code').val(data.currency_code);
                $('#currency_name').val(data.currency_name);
                $('#currency_symbol').val(data.currency_symbol);
                $('#currency_exchange_rate').val(data.currency_exchange_rate);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCurrency(id);
            });
        });

        function deleteCurrency(id) {
            var url = "{{ route('currencies.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Currency Deleted Successfully!');
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('currencies.index') }}" + '/' + id, function(data) {
                $('#showCurrencyModal').modal('show');
                $('#currencyShowForm #currency_code').val(data.currency_code);
                $('#currencyShowForm #currency_name').val(data.currency_name);
                $('#currencyShowForm #currency_symbol').val(data.currency_symbol);
                $('#currencyShowForm #currency_exchange_rate').val(data.currency_exchange_rate);
            });
        });

    });
</script>