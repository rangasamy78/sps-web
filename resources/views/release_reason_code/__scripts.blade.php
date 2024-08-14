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
                url: "{{ route('release_reason_codes.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'release_reason_code', name: 'release_reason_code' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createReleaseReasonCode').click(function () {
            $('.release_reason_code_error').html('');
            $('#savedata').html("Save Release Reason Code");
            $('#release_reason_code_id').val('');
            $('#releaseReasonCodeForm').trigger("reset");
            $('#modelHeading').html("Create New Release Reason Code");
            $('#releaseReasonCodeModel').modal('show');
        });
        $('#releaseReasonCodeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#release_reason_code_id').val() ? "{{ route('release_reason_codes.update', ':id') }}".replace(':id', $('#release_reason_code_id').val()) : "{{ route('release_reason_codes.store') }}";
            var type = $('#release_reason_code_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#releaseReasonCodeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#releaseReasonCodeForm').trigger("reset");
                        $('#releaseReasonCodeModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Release Reason Code Added Successfully!' : 'Release Reason Code Updated Successfully!';
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
            $('.release_reason_code_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('release_reason_codes.index') }}" + '/' + id + '/edit', function (data) {
                $(".release_reason_code_error").html("");
                $('#modelHeading').html("Edit Release Reason Code");
                $('#savedata').val("edit-release-reason-code");
                $('#savedata').html("Update Release Reason Code");
                $('#releaseReasonCodeModel').modal('show');
                $('#release_reason_code_id').val(data.id);
                $('#release_reason_code').val(data.release_reason_code);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteReleaseReasonCode(id);
            });
        });
        function deleteReleaseReasonCode(id) {
            var url = "{{ route('release_reason_codes.destroy', ':id') }}".replace(':id', id);
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
                        showSuccessMessage('Deleted!', 'Release Reason Code Deleted Successfully!');
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
            $.get("{{ route('release_reason_codes.index') }}" + '/' + id, function (data) {
                $('#showReleaseReasonCodeModal').modal('show');
                $('#showReleaseReasonCodeForm #release_reason_code').val(data.release_reason_code);

            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
