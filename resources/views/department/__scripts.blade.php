<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#departmentFilter').on('keyup change', function(e) {
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
                url: "{{ route('departments.list') }}",
                data: function (d) {
                    d.department_search = $('#departmentFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                }, // Row index column
                {
                    data: 'department_name',
                    name: 'department_name',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Department</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#departmentModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {
                        $('#savedata').html("Save Department");
                        $('#department_id').val('');
                        $('#departmentForm').trigger("reset");
                        $('.department_name_error').html('');
                        $('#modelHeading').html("Create New Department");
                        $('#departmentModel').modal('show');
                    }
                }
            ],
        });

        $('#departmentForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            if($("#department_id").val() == null || $("#department_id").val() == "")
            {
                storeDepartment();
            } else {
                updateDepartment();
            }
        });

        function storeDepartment()
        {
            $(this).html('Sending..');
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#departmentForm').serialize(),
                url: "{{ route('departments.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    if(response.status == "success"){
                        $('#departmentForm').trigger("reset");
                        $('#departmentModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    $('#savedata').html('Save Department');
                }
            });
        }

        function updateDepartment()
        {
            $(this).html('Sending..');
            let url = $('meta[name=app-url]').attr("content") + "/departments/" + $("#department_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#departmentForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(response.status == "success"){
                        $('#departmentForm').trigger("reset");
                        $('#departmentModel').modal('hide');
                        table.draw();
                        showToast('success', response.msg);
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
                    $('#savedata').html('Update Department');
                }
            });
        }

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('departments.index') }}" +'/' + id +'/edit', function (data) {
                $(".department_name_error").html("");
                $('#modelHeading').html("Edit Department");
                $('#savedata').val("edit-department");
                $('#savedata').html("Update Department");
                $('#departmentModel').modal('show');
                $('#department_id').val(data.id);
                $('#department_name').val(data.department_name);
            });
        });

        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            let url = $('meta[name=app-url]').attr("content") + "/departments/" + id;
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
                            handleAjaxResponse(response, table);
                        },
                        error: function(response) {
                            console.log(response.responseJSON);
                            showError('Oops!', 'Failed to fetch data.');
                        }
                    });
                }
            });
        });

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('departments.index') }}" +'/' + id, function (data) {
                $('#modelHeading').html("Show Department");
                $('#savedata').val("show-department");
                $('#showDepartmentmodal').modal('show');
                $('#showDepartmentForm #department_name').val(data.department_name);
            });
        });
    
    });
</script>
