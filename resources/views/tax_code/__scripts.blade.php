<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#componentNameFilter, #authorityFilter, #salesTaxIDFilter').on('keyup change', function(e) {
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
                url: "{{ route('tax_codes.list') }}",
                data: function(d) {
                    d.component_name = $('#componentNameFilter').val();
                    d.authority_id = $('#authorityFilter').val();
                    d.sales_tax_id = $('#salesTaxIDFilter').val();
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
                    data: 'sort_order',
                    name: 'sort_order'
                },
                {
                    data: 'tax_code',
                    name: 'tax_code'
                },
                {
                    data: 'tax_code_label',
                    name: 'tax_code_label'
                },
                {
                    data: 'current_rate',
                    name: 'current_rate'
                },
                {
                    data: 'rate_breakdown',
                    name: 'rate_breakdown'
                },
                {
                    data: 'notes',
                    name: 'notes'
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
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Tax Code</span>',
                className: 'create-new btn btn-primary',
                action: function (e, dt, node, config) {
                    // Redirect to Laravel route
                    window.location.href = "{{ route('tax_codes.create') }}";
                }
            }],

        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = $('#tax_code_id').val() ? "{{ route('tax_codes.update', ':id') }}".replace(':id', $('#tax_code_id').val()) : "{{ route('tax_codes.store') }}";
            var type = $('#tax_code_id').val() ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: $('#taxCodeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        setTimeout(function() {
                            window.location.href = "{{ route('tax_codes.index') }}";
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#authority_id').select2({
            placeholder: 'Select Authority',
            dropdownParent: $('#authority_id').parent()
        });

        $('#sales_tax_id').select2({
            placeholder: 'Select Sales Tax Account',
            dropdownParent: $('#sales_tax_id').parent()
        });

        $('#authorityFilter').select2({
            placeholder: 'Select Authority',
            dropdownParent: $('#authorityFilter').parent()
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCustomer(id);
            });
        });

        function deleteCustomer(id) {
            var url = "{{ route('tax_codes.destroy', ':id') }}".replace(':id', id);
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

        var maxFields = 10;
        var i = 0;
        $('#add').click(function() {
            const currentRowCount = $('#dynamic_table tr').length;
            if (currentRowCount <= maxFields) {
                $('#dynamic_table tbody').append(`
                    <tr id="row_${currentRowCount}">
                        <td><input type="text" name="tax_id[]" class="form-control" id="tax_id_${currentRowCount}" placeholder="Enter Tax ID" disabled="disabled"></td>
                        <td><select class="form-control tax_component_id" id="tax_component_id" name="tax_component_id[]" data-id="${currentRowCount}" data-allow-clear="true">
                            <option value="" selected>--Select Component--</option>
                            @foreach ($data['tax_components'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select></td>
                        <td><span id="tax_gl_account_${currentRowCount}"></span>
                            <input type="text" name="gl_account_name[]" class="form-control" id="gl_account_name_${currentRowCount}" placeholder="Enter Tax Gl Account"></td>
                        <td><input type="text" name="tax_rate[]" class="form-control tax_rate" id="tax_rate_${currentRowCount}" placeholder="Enter Rate" disabled="disabled"></td>
                        <td><button type="button" name="remove" id="${currentRowCount}" class="btn btn-danger btn_remove">X</button></td>
                    </tr>
                `);
                i++;
            } else {
                alert("Maximum " + maxFields + " rows are allowed.");
            }
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row_' + button_id).remove(); // Remove the row dynamically
        });

        $(document).on('change', '.tax_component_id', function() {
            var i = $(this).data('id');
            if ($(this).val()) {
                $('#tax_id_' + i).prop('disabled', false);
                $('#tax_rate_' + i).prop('disabled', false);
            } else {
                $('#tax_id_' + i).prop('disabled', true);
                $('#tax_rate_' + i).prop('disabled', true);
            }
        });

        $(document).on('change', '#component_name', function() {
            if ($(this).val()) {
                $('#new_tax_component_rate').prop('disabled', false);
            } else {
                $('#new_tax_component_rate').prop('disabled', true);
            }
        });

        $('#component_name').trigger('change');

        var sum = 0;
        $(document).on('change', '.tax_rate', function() {
            var sum = 0;
            $('.tax_rate').each(function() {
                var rate = parseInt($(this).val(), 10);
                if (!isNaN(rate)) {
                    sum += rate;
                }
            });
            $("#tax_sum").html(sum + ' %'); // Display the sum with a percentage sign
        });


        $(document).on('change', '.tax_component_id', function() {
            var textComponentId = $(this).val();
            var currentID = $(this).data('id');
            if (textComponentId) {
                var url = "{{ route('tax_codes.gl-account', ':id') }}";
                url = url.replace(':id', textComponentId); // Replace the placeholder with the actual ID
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.account_number) {
                            $('#tax_gl_account_'+currentID).html(response.account_number);
                            $('#gl_account_name_'+currentID).val(response.account_number);
                        } else {
                            alert(currentID)
                            $('#tax_gl_account_'+currentID).html('');
                            $('#gl_account_name_'+currentID).val('');
                        }
                    },
                    error: function() {
                        $('#tax_gl_account_'+currentID).val('Error fetching account number');
                        $('#gl_account_name_'+currentID).val('');
                    }
                });
            } else {
                $('#tax_gl_account_'+currentID).html('');
                $('#gl_account_name_'+currentID).val('');
            }
        });

     });
</script>

