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
                url: "{{ route('file_types.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'view_in', name: 'view_in' },
                { data: 'file_type', name: 'file_type' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createFileType').click(function () {
            resetForm();
            $('#savedata').html('Save File Type');
            $('#file_type_id').val('');
            $('#fileTypeForm').trigger("reset");
            $('#modelHeading').html("Create File Types");
            $('#fileTypeModel').modal('show');
        });

        $('#fileTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#fileTypeForm input, #fileTypeForm select').on('input change', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#file_type_id').val() ? "{{ route('file_types.update', ':id') }}".replace(':id', $('#file_type_id').val()) : "{{ route('file_types.store') }}";
            var type = $('#file_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#fileTypeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#fileTypeForm').trigger("reset");
                        $('#fileTypeModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'File Type Added Successfully!' : 'File Type Updated Successfully!';
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
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('file_types.index') }}" + '/' + id + '/edit', function (data) {
                $(".view_in_error").html("");
                $('#modelHeading').html("Edit  File Type");
                $('#savedata').val("edit-file_type");
                $('#savedata').html("Update File Type");
                $('#fileTypeModel').modal('show');
                $('#file_type_id').val(data.id);
                $('#view_in').val(data.view_in);
                $('#file_type').val(data.file_type);
                $('#file_type_opportunity').prop('checked', data.file_type_opportunity == 1);
                $('#file_type_quote').prop('checked', data.file_type_quote == 1);
                $('#file_type_saleorder').prop('checked', data.file_type_saleorder == 1);
                $('#file_type_invoice').prop('checked', data.file_type_invoice == 1);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteFileTypeColor(id);
            });
        });

        function deleteFileTypeColor(id) {
            var url = "{{ route('file_types.destroy', ':id') }}".replace(':id', id);
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
                        showSuccessMessage('Deleted!', 'File Type Deleted Successfully!');
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
            $.get("{{ route('file_types.index') }}" + '/' + id, function (data) {
                $(".view_in_error").html("");
                $('#modelHeading').html("Show File Type");
                $('#savedata').val("show-file_type");
                $('#showFileTypeModal').modal('show');
                $('#fileTypeShowForm #view_in').val(data.view_in);
                $('#fileTypeShowForm #file_type').val(data.file_type);
                $('#fileTypeShowForm #file_type_opportunity')
                    .prop('checked', data.file_type_opportunity == 1)
                    .prop('disabled', true);

                $('#fileTypeShowForm #file_type_quote')
                    .prop('checked', data.file_type_quote == 1)
                    .prop('disabled', true);

                $('#fileTypeShowForm #file_type_saleorder')
                    .prop('checked', data.file_type_saleorder == 1)
                    .prop('disabled', true);

                $('#fileTypeShowForm #file_type_invoice')
                    .prop('checked', data.file_type_invoice == 1)
                    .prop('disabled', true);
            });
        });
    });
    function resetForm() {
        $('.view_in_error').html('');
        $('.file_type_error').html('');
    }
</script>