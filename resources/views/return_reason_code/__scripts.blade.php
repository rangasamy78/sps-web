<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#returnReasonCodeFilter').on('keyup change', function(e) {
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
                url: "{{ route('return_reason_codes.list') }}",
                data: function(d) {
                    d.return_reason_code_search = $('#returnReasonCodeFilter').val();
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
                    data: 'return_code',
                    name: 'return_code'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Return Reason Code</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#returnReasonCodeModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {

                    $('#savedata').html("Save Return Reason Code");
                    $('#return_code_id').val('');
                    $('#returnReasonCodeForm').trigger("reset");
                    $('.return_code_error').html('');
                    $('#modelHeading').html("Create New Return Reason Code");
                    $('#returnReasonCodeModel').modal('show');
                }
            }],
        });

        $('#returnReasonCodeForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#return_code_id').val() ? "{{ route('return_reason_codes.update', ':id') }}".replace(':id', $('#return_code_id').val()) : "{{ route('return_reason_codes.store') }}";
            var type = $('#return_code_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#returnReasonCodeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#returnReasonCodeForm').trigger("reset");
                        $('#returnReasonCodeModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        $('body').on('click', '.editbtn', function() {
            $('.return_code_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('return_reason_codes.index') }}" + '/' + id + '/edit', function(data) {
                $(".return_code_error").html("");
                $('#modelHeading').html("Edit Return Reason Code");
                $('#savedata').val("edit-return-reason-code");
                $('#savedata').html("Update Return Reason Code");
                $('#returnReasonCodeModel').modal('show');
                $('#return_code_id').val(data.id);
                $('#return_code').val(data.return_code);
            });
        });
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteReturnReasonCode(id);
            });
        });

        function deleteReturnReasonCode(id) {
            var url = "{{ route('return_reason_codes.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table);
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('return_reason_codes.index') }}" + '/' + id, function(data) {
                $('#showReturnReasonCodeModal').modal('show');
                $('#showReturnReasonCodeForm #return_code').val(data.return_code);

            });
        });
    });
</script>
