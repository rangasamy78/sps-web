<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#quotePrintedNoteFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#quotePrintedNoteTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('quote_printed_notes.list') }}",
                data: function(d) {
                    d.quote_printed_note_name_search = $('#quotePrintedNoteFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }]; // Order by the correct column index
                }
            },
            columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'quote_printed_notes_name',
                    name: 'quote_printed_notes_name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Add the serial number in the first column
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Quote Printed Note</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#showQuotePrintedNoteForm',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Quote Printed Note");
                    $('#quote_printed_notes_name').val('');
                    $('#quotePrintedNoteForm').trigger("reset");
                    $(".quote_printed_notes_name_error").html("");
                    $('#modelHeading').html("Create New Quote Printed Note");
                    $('#showQuotePrintedNoteForm').modal('show');
                }
            }],

        });

        $('#quote_printed_notes_name').on('input', function() {
            $('.quote_printed_notes_name_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#quote_printed_notes_id').val() ? "{{ route('quote_printed_notes.update', ':id') }}".replace(':id', $('#quote_printed_notes_id').val()) : "{{ route('quote_printed_notes.store') }}";
            var type = $('#quote_printed_notes_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#quotePrintedNoteForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#quotePrintedNoteForm').trigger("reset");
                        $('#showQuotePrintedNoteForm').modal('hide');
                        table.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $(".quote_printed_notes_name_error").html("");
            $.get("{{ route('quote_printed_notes.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Quote Printed Note");
                $('#savedata').html("Update Quote Printed Note");
                $('#showQuotePrintedNoteForm').modal('show');
                $('#quote_printed_notes_id').val(data.id);
                $('#quote_printed_notes_name').val(data.quote_printed_notes_name);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteAboutUsOption(id);
            });
        });

        function deleteAboutUsOption(id) {
            var url = "{{ route('quote_printed_notes.destroy', ':id') }}".replace(':id', id);
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
        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('quote_printed_notes.index') }}" + '/' + id, function(data) {
                $('#showQuotePrintedNoteModal').modal('show');
                $('#showQuotePrintedNoteForm #quote_printed_notes_name').val(data.quote_printed_notes_name);
            });
        });

    });
</script>