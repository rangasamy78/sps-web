<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#expenditureNameFilter, #addressFilter, #phoneFilter').on('keyup change', function(e) {
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
                url: "{{ route('expenditures.list') }}",
                data: function(d) {
                    d.expenditure_name_search = $('#expenditureNameFilter').val();
                    d.address_search = $('#addressFilter').val();
                    d.phone_fax_email_search = $('#phoneFilter').val();
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
                    data: 'expenditure_name',
                    name: 'expenditure_name'
                },
                {
                    data: 'print_name',
                    name: 'print_name'
                },
                {
                    data: 'expenditure_type_id',
                    name: 'expenditure_type_id'
                },
                {
                    data: 'address_combined',
                    name: 'address'
                },
                {
                    data: 'phone_combined',
                    name: 'primary_phone'
                },
                {
                    data: 'parent_location_id',
                    name: 'parent_location_id'
                },
                {
                    data: 'payment_method_id',
                    name: 'payment_method_id'
                },
                {
                    data: 'account',
                    name: 'account'
                },
                {
                    data: 'internal_notes',
                    name: 'internal_notes'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Add the serial number in the first column
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Expenditure</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        id: 'createExpenditure',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('expenditures.create') }}";
                    }
                }],
                action: function(e, dt, node, config) {

                    $('#savedata').html("Save Expenditure");
                    $('#expenditure_id').val('');
                    $('#expenditureForm').trigger("reset");
                    $('.expenditure_name_error').html('');
                    $('#modelHeading').html("Create New Expenditure");
                    $('#expenditureModel').modal('show');
                }

        });

        $('#expenditure_type_id').select2({
            placeholder: 'Select Expenditure Type',
            dropdownParent: $('#expenditure_type_id').parent()
        });

        $('#parent_location_id').select2({
            placeholder: 'Select Parent Location',
            dropdownParent: $('#parent_location_id').parent()
        });

        $('#country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#country_id').parent()
        });

        $('#shipping_country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#shipping_country_id').parent()
        });

        $('#payment_term_id').select2({
            placeholder: 'Select Payment Term',
            dropdownParent: $('#payment_term_id').parent()
        });

        $('#expense_account_id').select2({
            placeholder: 'Select Default Expense Account',
            dropdownParent: $('#expense_account_id').parent()
        });

        $('#payment_method_id').select2({
            placeholder: 'Select Payment Term',
            dropdownParent: $('#payment_method_id').parent()
        });

        $('#expenditureForm input, #expenditureForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#expenditureForm').on('input', function() {
            let fieldName = $(this).attr('name');
            $val = $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#expenditure_id').val() ? "{{ route('expenditures.update', ':id') }}".replace(':id', $('#expenditure_id').val()) : "{{ route('expenditures.store') }}";
            var type = $('#expenditure_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#expenditureForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#expenditureForm').trigger("reset");
                        // $('#expenditureModel').modal('hide');
                        table.draw();
                        window.location.href = "{{ route('expenditures.index') }}";
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                    window.scrollTo(0, 0);
                }
            });
        });

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('expenditures.index') }}" + '/' + id + '/edit', function(data) {
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteExpenditure(id);
            });
        });

        function deleteExpenditure(id) {
            var url = "{{ route('expenditures.destroy', ':id') }}".replace(':id', id);
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
        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('about_us_options.index') }}" + '/' + id, function(data) {
                $('#showAboutUsOptionModal').modal('show');
                $('#showAboutUsOptionForm #how_did_you_hear_option').val(data.how_did_you_hear_option);
            });
        });

        $(document).on('click', '.change_status', function() {

        var id = $(this).data('id');
        var button = $(this);
        var url = "{{ route('expenditures.expenditure_change_status', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (response.new_status == 1) {
                        button.removeClass('btn-danger').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                    }
                    showToast('success', response.msg);
                }
            }
        });
        });

    });
</script>
