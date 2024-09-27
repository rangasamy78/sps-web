<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#nameFilter, #codeFilter, #emailFilter, #departmentFilter, #designationFilter').on('keyup change', function(e) {
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
                url: "{{ route('users.list') }}",
                data: function(d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.name_search   = $('#nameFilter').val();
                    d.code_search = $('#codeFilter').val();
                    d.email_search   = $('#emailFilter').val();
                    d.department_search = $('#departmentFilter').val();
                    d.designation_search = $('#designationFilter').val();
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'departments',
                    name: 'departments'
                },
                {
                    data: 'designations',
                    name: 'designations'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add User</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#userModel',
                },
                action: function(e, dt, node, config) {
                    resetForm();
                    $('#password_mandatory').show();
                    $('#c_password_mandatory').show();
                    $('#department_id').val('').trigger('change');
                    $('#designation_id').val('').trigger('change');
                    $('#savedata').html("Save User");
                    $('#user_id').val('');
                    $('#userForm').trigger("reset");
                    $('#modelHeading').html("Create New User");
                    $('#userModel').modal('show');
                }
            }],
        });

        $('#departmentFilter').select2({
            placeholder: 'Select Department',
            dropdownParent: $('#departmentFilter').parent()
        });

        $('#designationFilter').select2({
            placeholder: 'Select Designation',
            dropdownParent: $('#designationFilter').parent()
        });
        $('#userForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#userForm input, #userForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#user_id').val() ? "{{ route('users.update', ':id') }}".replace(':id', $('#user_id').val()) : "{{ route('users.store') }}";
            var type = $('#user_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#userForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#userForm').trigger("reset");
                        $('#userModel').modal('hide');
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
            resetForm();

            var id = $(this).data('id');
            $.get("{{ route('users.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Edit User");
                $('#userModel').modal('show');
                $('#password_mandatory').hide();
                $('#c_password_mandatory').hide();
                $('#savedata').val("edit-user");
                $('#savedata').html("Update User");
                $('#user_id').val(data.id);
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#code').val(data.code);
                $('#email').val(data.email);
                $('#password').val("");
                $('#confirm_password').val("");
                $('#department_id').val(data.department_id).trigger('change');
                getDesignation(data.department_id, data.designation_id, "edit");
            });
        });

        $('#department_id').select2({
            placeholder: 'Select Department',
            dropdownParent: $('#department_id').parent()
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteUser(id);
            });
        });

        function deleteUser(id) {
            var url = "{{ route('users.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('users.index') }}" + '/' + id, function(data) {

                $('#showUserModal').modal('show');
                $('#showUserForm #first_name').val(data.first_name);
                $('#showUserForm #last_name').val(data.last_name);
                $('#showUserForm #code').val(data.code);
                $('#showUserForm #email').val(data.email);
                $('#showUserForm #department_id').val(data.department_id).prop('disabled', true);
                getDesignation(data.department_id, data.designation_id, "show");

            });
        });

        function resetForm() {
            $('.first_name_error').html('');
            $('.code_error').html('');
            $('.email_error').html('');
            $('.password_error').html('');
            $('.password_confirmation_error').html('');
            $('.department_id_error').html('');
            $('.designation_id_error').html('');
        }

        $(document).ready(function() {
        $('#department_id, #departmentFilter').on('change', function() {
            var typeId = $(this).val();
            getDesignation(typeId, "", "create");
        });
    });

    function getDesignation(typeId, selectedDesignationId, type) {

        var $designation;
        if (type === "show") {
            $designation = $('#showUserForm #designation_id');
        } else if (type === "edit") {
            $designation = $('#designation_id');
        } else {
            $designation = $([
                '#designation_id',
                '#designationFilter'
            ].join(', '));
        }

        $designation.empty().append('<option value="">Select Designation</option>');

        if (typeId) {
            $.ajax({
                url: '{{ route("get_designation") }}',
                type: 'GET',
                data: {
                    type_id: typeId
                },
                success: function(data) {

                    $.each(data.designations, function(key, value) {
                    if (value.id !== null) {

                        if ($designation.find('option[value="' + value.id + '"]').length === 0) {
                            $designation.append('<option value="' + value.id + '">' + value.designation_name + '</option>');
                        }
                    }
                });

                    if (selectedDesignationId) {
                        $designation.val(selectedDesignationId);
                    }
                    $designation.prop('disabled', type === "show");
                },
                error: function() {
                    $designation.empty().append('<option value="">Select Designation</option>');
                    $designation.prop('disabled', type === "show");
                }
            });
        } else {
            $designation.prop('disabled', type === "show");
        }
        }
    });
</script>
