<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#currencyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('currencies.list') }}",
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
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function(data, type, row) {
                        if (data) {
                            return moment(data).format('DD-MM-YYYY HH:mm:ss'); // Change format as needed
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(index + 1); // Update the index column with the correct row index
            },
            columnDefs: [{
                targets: -1,
                orderable: false
            }],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            // displayLength: 7,
            // lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [{
                    extend: 'collection',
                    className: 'btn btn-label-primary dropdown-toggle me-2',
                    text: '<i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [{
                            extend: 'print',
                            text: '<i class="bx bx-printer me-1"></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            },
                            customize: function(win) {
                                $(win.document.body)
                                    .css('color', '#333')
                                    .css('background-color', '#fff');
                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('color', 'inherit')
                                    .css('border-color', 'inherit')
                                    .css('background-color', 'inherit');
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="bx bx-file me-1"></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="bx bxs-file-export me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            text: '<i class="bx bx-copy me-1"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Record</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#currencyModel',
                        'id': 'createCurrency',
                    },
                    action: function(e, dt, node, config) {
                        // Custom action for Add New Record button
                        $('#saveCurrency').val("create-currency");
                        $('#currency_id').val('');
                        $('#currencyForm').trigger("reset");
                        $('#modelHeading').html("Create New Currency");
                        $('#currencyModel').modal('show');
                    }
                }
            ],


        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
                '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
                '30px');
        }, 300);
        $('#saveCurrency').click(function(e) {
            let v = $("#currency_id").val();
            e.preventDefault();
            if ($("#currency_id").val() == null || $("#currency_id").val() == "") {
                storeCurrency();
            } else {
                updateCurrency();
            }
        });

        $('#currencyForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        function storeCurrency() {
            $(this).html('Sending..');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#currencyForm').serialize(),
                url: "{{ route('currencies.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#currencyForm').trigger("reset");
                        $('#currencyModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: 'Created!',
                            text: 'Currency Added Successfully!',
                            type: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.msg,
                            type: response.status,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    $('#saveCurrency').html('Save Currency');
                }
            });
        }

        function updateCurrency() {
            $(this).html('Sending..');
            let url = $('meta[name=app-url]').attr("content") + "/currencies/" + $("#currency_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#currencyForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#currencyForm').trigger("reset");
                        $('#currencyModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: 'Updated!',
                            text: 'Currency Updated Successfully!',
                            type: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Updated!',
                            text: response.msg,
                            type: response.status,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    console.log('Error:', data);
                    $('#savedata').html('Update State');
                }
            });
        }

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('currencies.index') }}" + '/' + id + '/edit', function(data) {
                $(".name_error").html("");
                $('#modelHeading').html("Update Bin Type");
                $('#savedata').val("edit-user");
                $('#savedata').html("Update Bin");
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
            let url = $('meta[name=app-url]').attr("content") + "/currencies/" + id;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-1',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: "DELETE",
                        data: {
                            id: $("#id").val(),
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                table.draw();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Currency Deleted Successfully!',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            }
                        },
                        error: function(response) {
                            console.log(response.responseJSON);
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                }
            });
        });

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('currencies.index') }}" + '/' + id, function(data) {
                $(".name_error").html("");
                $('#showCurrencyModal').modal('show');
                $('#currencyShowForm #currency_code').val(data.currency_code);
                $('#currencyShowForm #currency_name').val(data.currency_name);
                $('#currencyShowForm #currency_symbol').val(data.currency_symbol);
                $('#currencyShowForm #currency_exchange_rate').val(data.currency_exchange_rate);
            });
        });

    });
</script>