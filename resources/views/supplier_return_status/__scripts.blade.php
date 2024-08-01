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
                url: "{{ route('supplier_return_statuses.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'return_code_name', name: 'return_code_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createSupplierReturnStatus').click(function () {
            $('.reason_code_name_error').html('');
            $('#savedata').html("Save Supplier Return Status");
            $('#return_code_id').val('');
            $('#supplierReturnStatusForm').trigger("reset");
            $('#modelHeading').html("Create New Supplier Return Status");
            $('#supplierReturnStatusModel').modal('show');
        });
        $('#supplierReturnStatusForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#return_code_id').val() ? "{{ route('supplier_return_statuses.update', ':id') }}".replace(':id', $('#return_code_id').val()) : "{{ route('supplier_return_statuses.store') }}";
            var type = $('#return_code_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#supplierReturnStatusForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#supplierReturnStatusForm').trigger("reset");
                        $('#supplierReturnStatusModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Supplier Return Status Added Successfully!' : 'Supplier Return Status Updated Successfully!';
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
            $('.return_code_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('supplier_return_statuses.index') }}" + '/' + id + '/edit', function (data) {
                $(".return_code_error").html("");
                $('#modelHeading').html("Edit Supplier Return Status");
                $('#savedata').val("edit-supplier-return-status");
                $('#savedata').html("Update Supplier Return Status");
                $('#supplierReturnStatusModel').modal('show');
                $('#return_code_id').val(data.id);
                $('#return_code_name').val(data.return_code_name);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteSupplierReturnStatus(id);
            });
        });
        function deleteSupplierReturnStatus(id) {
            var url = "{{ route('supplier_return_statuses.destroy', ':id') }}".replace(':id', id);
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
                        showSuccessMessage('Deleted!', 'Supplier Return Status Deleted Successfully!');
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
            $.get("{{ route('supplier_return_statuses.index') }}" + '/' + id, function (data) {
                $('#showSupplierReturnStatusModal').modal('show');
                $('#showSupplierReturnStatusForm #return_code_name').val(data.return_code_name);

            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
