<script type="text/javascript">
    $(function() {

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
                url: "{{ route('project_types.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'project_type_name', name: 'project_type_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createProjectType').click(function () {
            $('#savedata').val("create-project-type");
            $('#savedata').html("Save Project Type");
            $('#project_type_id').val('');
            $('#projectTypeForm').trigger("reset");
            $('.project_type_name_error').html('');
            $('#modelHeading').html("Create New Project Type");
            $('#projectTypeModel').modal('show');
        });

        $('#projectTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
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
                        table.draw();
                        var successMessage = type === 'POST' ? 'Project Type Added Successfully!' : 'Project Type Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    var button = type === 'POST' ? 'Save Project Type' : 'Update Project Type';
                    $('#savedata').html(button);
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
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Project Type Deleted Successfully!');
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

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
