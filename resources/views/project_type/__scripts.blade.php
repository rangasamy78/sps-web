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
            ajax: "{{ route('project_types.list') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                }, // Row index column
                {
                    data: 'project_type_name',
                    name: 'project_type_name',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(index + 1); // Update the index column with the correct row index
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

        $('#savedata').click(function (e) {
            e.preventDefault();
            if($("#project_type_id").val() == null || $("#project_type_id").val() == "")
            {
                storeProjectType();
            } else {
                updateProjectType();
            }
        });

        function storeProjectType()
        {
            $(this).html('Sending..');
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#projectTypeForm').serialize(),
                url: "{{ route('project_types.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    if(response.status == "success"){
                        $('#projectTypeForm').trigger("reset");
                        $('#projectTypeModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: 'Created!',
                            text: 'Project Type Added Successfully!',
                            type: 'success',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    $('#savedata').html('Save Project Type');
                }
            });
        }

        function updateProjectType()
        {
            $(this).html('Sending..');
            let url = $('meta[name=app-url]').attr("content") + "/project_types/" + $("#project_type_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#projectTypeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(response.status == "success"){
                        $('#projectTypeForm').trigger("reset");
                        $('#projectTypeModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: 'Updated!',
                            text: 'Project Type Updated Successfully!',
                            type: 'success',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    console.log('Error:', data);
                    $('#savedata').html('Update Project Type');
                }
            });
        }

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
            let url = $('meta[name=app-url]').attr("content") + "/project_types/" + id;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                confirmButton: 'btn btn-primary me-1',
                cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: "DELETE",
                        data: {
                            id: $("#id").val(),
                        },
                        success: function(response) {
                            if(response.status == "success"){
                                table.draw();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Project Type Deleted Successfully!',
                                    customClass: {
                                    confirmButton: 'btn btn-success'
                                    }
                                });
                            }
                        },
                        error: function(response) {
                            console.log(response.responseJSON);
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                }
            });
        });

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('project_types.index') }}" +'/' + id, function (data) {
                $('#modelHeading').html("Show Project Type");
                $('#savedata').val("edit-project-type");
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
