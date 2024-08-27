<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#projectTypeFilter').on('keyup change', function(e) {
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
                url: "{{ route('project_types.list') }}",
                data: function (d) {
                    d.project_type_search = $('#projectTypeFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'project_type_name', name: 'project_type_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Project Type</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#projectTypeModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {

                        $('#savedata').html("Save Project Type");
                        $('#project_type_id').val('');
                        $('#projectTypeForm').trigger("reset");
                        $('.project_type_name_error').html('');
                        $('#modelHeading').html("Create New Project Type");
                        $('#projectTypeModel').modal('show');
                    }
                }
            ],
        });

        $('#projectTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#project_type_id').val() ? "{{ route('project_types.update', ':id') }}".replace(':id', $('#project_type_id').val()) : "{{ route('project_types.store') }}";
            var type = $('#project_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#projectTypeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#projectTypeForm').trigger("reset");
                        $('#projectTypeModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('project_types.index') }}" +'/' + id +'/edit', function (data) {
                $(".project_type_name_error").html("");
                $('#modelHeading').html("Edit Project Type");
                $('#savedata').val("edit-project-type");
                $('#savedata').html("Update Project Type");
                $('#projectTypeModel').modal('show');
                $('#project_type_id').val(data.id);
                $('#project_type_name').val(data.project_type_name);
            });
        });


        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteProjectType(id);
            });
        });

        function deleteProjectType(id) {
            var url = "{{ route('project_types.destroy', ':id') }}".replace(':id', id);

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

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('project_types.index') }}" +'/' + id, function (data) {
                $('#modelHeading').html("Show Project Type");
                $('#savedata').val("show-project-type");
                $('#showProjectTypeModal').modal('show');
                $('#showProjectTypeForm #project_type_name').val(data.project_type_name);
            });
        });
    });
</script>
