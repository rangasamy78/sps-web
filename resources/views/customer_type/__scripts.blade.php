<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('customer_types.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'customer_type_name', name: 'customer_type_name' },
                { data: 'customer_type_code', name: 'customer_type_code' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
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
            $(this).html('Sending..');
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
                    var button = type === 'POST' ? 'Save Customer Type' : 'Update Customer Type';
                    $('#savedata').html(button);
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

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
