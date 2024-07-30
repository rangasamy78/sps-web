<script type="text/javascript">
    $(function () {

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
                url: "{{ route('product_groups.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'product_group_name', name: 'product_group_name' },
                { data: 'product_group_code', name: 'product_group_code' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createProductGroup').click(function () {
            $('.product_group_name_error').html('');
            $('#savedata').html("Save Product Group");
            $('#product_group_id').val('');
            $('#productGroupForm').trigger("reset");
            $('#modelHeading').html("Create New Product Group");
            $('#productGroupModel').modal('show');
        });

        $('#productGroupForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#product_group_id').val() ? "{{ route('product_groups.update', ':id') }}".replace(':id', $('#product_group_id').val()) : "{{ route('product_groups.store') }}";
            var type = $('#product_group_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productGroupForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#productGroupForm').trigger("reset");
                        $('#productGroupModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Product Group Added Successfully!' : 'Product Group Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            $('.product_group_name_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('product_groups.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit Product Group");
                $('#savedata').val("edit-product-group");
                $('#savedata').html("Update Product Group");
                $('#productGroupModel').modal('show');
                $('#product_group_id').val(data.id);
                $('#product_group_name').val(data.product_group_name);
                $('#product_group_code').val(data.product_group_code);
            });
        });

        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteProductGroup(id);
            });
        });

        function deleteProductGroup(id) {
            var url = "{{ route('product_groups.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Product Group Deleted Successfully!');
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('product_groups.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Product Group");
                $('#savedata').val("edit-product-group");
                $('#showProductGroupModal').modal('show');
                $('#showProductGroupForm #product_group_name').val(data.product_group_name);
                $('#showProductGroupForm #product_group_code').val(data.product_group_code);
            });
        });
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>