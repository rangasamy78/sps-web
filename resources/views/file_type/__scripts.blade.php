<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#viewInFilter, #fileTypeFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('file_types.list') }}",
                data: function (d) {
                    d.view_in_search = $('#viewInFilter').val();
                    d.file_type_search = $('#fileTypeFilter').val();
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
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Create File Types</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#fileTypeForm',
                },
                action: function(e, dt, node, config) {
                    resetForm();
                    $('#savedata').html('Save File Type');
                    $('#file_type_id').val('');
                    $('#fileTypeForm').trigger("reset");
                    $('#modelHeading').html("Create File Types");
                    $('#fileTypeModel').modal('show');
                }
            }],
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
                deleteFileType(id);
            });
        });

        function deleteFileType(id) {
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
                        table.draw();
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
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
    function resetForm() {
        $('.view_in_error').html('');
        $('.file_type_error').html('');
    }
    $(document).ready(function () {
        $('#importFileType').click(function () {

        $('#importFileTypeModal').modal('show');
        });
        $('#importFileTypeModal').on('show.bs.modal', function () {
            $('#file').val('');
            $('span.file_error').text('');
        });

    $('#uploadForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('file', $('#file')[0].files[0]);
        let table = $('#datatable').DataTable();

    $.ajax({
        url: '{{ route("file_types.import") }}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#uploadForm').trigger("reset");
            $('#importFileTypeModal').modal('hide');
            table.draw();

            let message = '';
            let icon = 'success';

            if(response.status === "success"){
                message = 'File uploaded and processed successfully!';
            } else if(response.status === "warning"){
                message = 'File processed with some issues:<br><br>';
                icon = 'warning';
                response.errors.forEach(function (error) {
                    message += '<span style="display: block; text-align: left; margin-bottom: 4px; padding: 2px;  #ccc; background-color: #f9f9f9;">' + error + '</span>';

                });
            }

            Swal.fire({
                title: response.status.charAt(0).toUpperCase() + response.status.slice(1) + '!',
                html: message,
                icon: icon,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
         },
        error: function(xhr) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function(prefix, val) {
                    $('span.' + prefix + '_error').text(val[0]);
                });
            }
            }
        });
    });

    $('#downloadFileType').on('click', function ()
    {
    window.location.href = "{{ route('file_type.template_download') }}";
    });
});


</script>
