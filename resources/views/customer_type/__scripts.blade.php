<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#customerTypeNameFilter, #customerTypeCodeFilter').on('keyup', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#customerTypeTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('customer_types.list') }}",
                data: function (d) {
                    d.customer_type_name_search = $('#customerTypeNameFilter').val();
                    d.customer_type_code_search = $('#customerTypeCodeFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'customer_type_name', name: 'customer_type_name' },
                { data: 'customer_type_code', name: 'customer_type_code' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Create Customer Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#customerTypeModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Customer Type");
                    $('#customer_type_id').val('');
                    $('#expenseCategoryForm').trigger("reset");
                    $(".customer_type_name_error").html("");
                    $('#modelHeading').html("Create New Customer Type");
                    $('#expenseCategorycustomerTypeModelModel').modal('show');
                }
            }],
        });

        $('#createCustomerType').click(function () {
            $('#savedata').val("create-customer-type");
            $('#savedata').html("Save Customer Type");
            $('#customer_type_id').val('');
            $('#customerTypeForm').trigger("reset");
            $('.customer_type_name_error').html('');
            $('#modelHeading').html("Create New Customer Type");
            $('#customerTypeModel').modal('show');
        });

        $('#customerTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#customer_type_id').val() ? "{{ route('customer_types.update', ':id') }}".replace(':id', $('#customer_type_id').val()) : "{{ route('customer_types.store') }}";
            var type = $('#customer_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#customerTypeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#customerTypeForm').trigger("reset");
                        $('#customerTypeModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('customer_types.index') }}" +'/' + id +'/edit', function (data) {
                $(".customer_type_name_error").html("");
                $('#modelHeading').html("Edit Customer Type");
                $('#savedata').val("edit-customer-type");
                $('#savedata').html("Update Customer Type");
                $('#customerTypeModel').modal('show');
                $('#customer_type_id').val(data.id);
                $('#customer_type_name').val(data.customer_type_name);
                $('#customer_type_code').val(data.customer_type_code);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCustomerType(id);
            });
        });

        function deleteCustomerType(id) {
            var url = "{{ route('customer_types.destroy', ':id') }}".replace(':id', id);

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

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('customer_types.index') }}" +'/' + id, function (data) {
                $('#modelHeading').html("Show Customer Type");
                $('#savedata').val("show-customer-type");
                $('#showCustomerTypeModal').modal('show');
                $('#showCustomerTypeForm #customer_type_name').val(data.customer_type_name);
                $('#showCustomerTypeForm #customer_type_code').val(data.customer_type_code);
            });
        });
    });
</script>
