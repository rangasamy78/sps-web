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
                url: "{{ route('receiving_qc_notes.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'code', name: 'code' },
                { data: 'notes', name: 'notes' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createReceivingQcNote').click(function () {
            resetFormFields();
            $('#savedata').html("Save Receiving Qc Note");
            $('#code_id').val('');
            $('#receivingQcNoteForm').trigger("reset");
            $('#modelHeading').html("Create New Receiving Qc Note");
            $('#receivingQcNoteModel').modal('show');
        });
        $('#receivingQcNoteForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
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
                        table.draw();
                        var successMessage = type === 'POST' ? 'Receiving Qc Note Added Successfully!' : 'Receiving Qc Note Updated Successfully!';
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
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Receiving Qc Note Deleted Successfully!');
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

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);

        function resetFormFields(){
            $('.code_error').html('');
            $('.notes_error').html('');
        }
    });

</script>