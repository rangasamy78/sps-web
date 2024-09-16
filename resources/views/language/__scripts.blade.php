<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#languageNameFilter').on('keyup change', function(e) {
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
                url: "{{ route('languages.list') }}",
                data: function(d) {
                    d.language_name_search = $('#languageNameFilter').val();
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
                    data: 'language_name',
                    name: 'language_name'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Language</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#languageModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Language");
                    $(".language_name_error").html("");
                    $('#language_id').val('');
                    $('#languageForm').trigger("reset");
                    $('#languageForm').trigger("reset");
                    $("#languageForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Language");
                    $('#languageModel').modal('show');
                }
            }],

        });

        $('#languageForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#language_id').val() ? "{{ route('languages.update', ':id') }}".replace(':id', $('#language_id').val()) : "{{ route('languages.store') }}";
            var type = $('#language_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#languageForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#languageForm').trigger("reset");
                        $('#languageModel').modal('hide');
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
            var id = $(this).data('id');
            $.get("{{ route('languages.index') }}" + '/' + id + '/edit', function(data) {
                $(".language_name_error").html("");
                $('#modelHeading').html("Edit Language");
                $('#savedata').val("edit-language");
                $('#savedata').html("Update Language");
                $('#languageModel').modal('show');
                $('#language_id').val(data.id);
                $('#language_name').val(data.language_name);
            });
        });


        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteLanguage(id);
            });
        });

        function deleteLanguage(id) {
            var url = "{{ route('languages.destroy', ':id') }}".replace(':id', id);

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
            $.get("{{ route('languages.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Language");
                $('#savedata').val("show-language");
                $('#showLanguagemodal').modal('show');
                $('#showLanguageForm #language_name').val(data.language_name);
            });
        });
    });
</script>
