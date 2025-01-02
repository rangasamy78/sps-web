<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#quoteHeaderFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#quoteHeaderTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('quote_headers.list') }}",
                data: function(d) {
                    d.quote_header_name_search = $('#quoteHeaderFilter').val();
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
                    data: 'quote_header_name',
                    name: 'quote_header_name'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Quote Header</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#showQuoteHeaderForm',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Quote Header");
                    $('#quote_header_name').val('');
                    $('#quoteHeaderForm').trigger("reset");
                    $(".quote_header_name_error").html("");
                    $('#modelHeading').html("Create New Quote Header");
                    $('#showQuoteHeaderForm').modal('show');
                }
            }],

        });

        $('#quote_header_name').on('input', function() {
            $('.quote_header_name_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#quote_header_name_id').val() ? "{{ route('quote_headers.update', ':id') }}".replace(':id', $('#quote_header_name_id').val()) : "{{ route('quote_headers.store') }}";
            var type = $('#quote_header_name_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#quoteHeaderForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#quoteHeaderForm').trigger("reset");
                        $('#showQuoteHeaderForm').modal('hide');
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
            $(".quote_header_name_error").html("");
            $.get("{{ route('quote_headers.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Quote Header");
                $('#savedata').val("how-did-you-hear-option");
                $('#savedata').html("Update Quote Header");
                $('#showQuoteHeaderForm').modal('show');
                $('#quote_header_name_id').val(data.id);
                $('#quote_header_name').val(data.quote_header_name);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteAboutUsOption(id);
            });
        });

        function deleteAboutUsOption(id) {
            var url = "{{ route('quote_headers.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('quote_headers.index') }}" + '/' + id, function(data) {
                $('#showQuoteHeaderModal').modal('show');
                $('#showQuoteHeaderForm #quote_header_name').val(data.quote_header_name);
            });
        });

    });
</script>