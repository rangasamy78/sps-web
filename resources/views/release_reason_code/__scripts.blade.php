<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#reasonCodeFilter').on('keyup change', function(e) {
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
                url: "{{ route('release_reason_codes.list') }}",
                data: function (d) {
                    d.reason_code_search = $('#reasonCodeFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'release_reason_code', name: 'release_reason_code' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Release Reason Code</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#releaseReasonCodeModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {

                        $('#savedata').html("Save Release Reason Code");
                        $('#release_reason_code_id').val('');
                        $('#releaseReasonCodeForm').trigger("reset");
                        $('.release_reason_code_error').html('');
                        $('#modelHeading').html("Create New Release Reason Code");
                        $('#releaseReasonCodeModel').modal('show');
                    }
                }
            ],
        });

        $('#releaseReasonCodeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
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
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
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
                        handleAjaxResponse(response, table);
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
    });
</script>
