<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#returnCodeFilter, #notesFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('receiving_qc_notes.list') }}",
                data: function (d) {
                    d.code_search = $('#returnCodeFilter').val();
                    d.notes_search = $('#notesFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'code', name: 'code' },
                { data: 'notes', name: 'notes' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Receiving Qc Note</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#receivingQcNoteModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Receiving Qc Note");
                    resetFormFields();
                    $('#receivingQcNoteForm').trigger("reset");
                    $('#modelHeading').html("Create New Receiving Qc Note");
                    $('#receivingQcNoteModel').modal('show');
                }
            }],
        });

        $('#receivingQcNoteForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#code_id').val() ? "{{ route('receiving_qc_notes.update', ':id') }}".replace(':id', $('#code_id').val()) : "{{ route('receiving_qc_notes.store') }}";
            var type = $('#code_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#receivingQcNoteForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#receivingQcNoteForm').trigger("reset");
                        $('#receivingQcNoteModel').modal('hide');
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
            var id = $(this).data('id');
            $.get("{{ route('receiving_qc_notes.index') }}" + '/' + id + '/edit', function (data) {
                resetFormFields();
                $('#modelHeading').html("Edit Receiving Qc Note");
                $('#savedata').val("edit-teceiving-qc-note");
                $('#savedata').html("Update Receiving Qc Note");
                $('#receivingQcNoteModel').modal('show');
                $('#code_id').val(data.id);
                $('#code').val(data.code);
                $('#notes').val(data.notes);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteReceivingQcNote(id);
            });
        });
        function deleteReceivingQcNote(id) {
            var url = "{{ route('receiving_qc_notes.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('receiving_qc_notes.index') }}" + '/' + id, function (data) {
                $('#showReceivingQcNoteModal').modal('show');
                $('#showReceivingQcNoteForm #code').val(data.code);
                $('#showReceivingQcNoteForm #notes').val(data.notes);

            });
        });

        function resetFormFields(){
            $('.code_error').html('');
            $('.notes_error').html('');
        }
    });

</script>
