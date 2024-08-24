<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#departmentFilter, #designationFilter').on('keyup change', function(e) {
                e.preventDefault();
                table.draw();
            });
        var table = $('#createDesignation').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('designations.list') }}",
                data: function(d) {
                    d.department_search = $('#departmentFilter').val();
                    d.designation_search = $('#designationFilter').val();
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
                    data: 'department_id',
                    name: 'department_id',
                },
                {
                    data: 'designation_name',
                    name: 'designation_name',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,

                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },

            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Create Designation</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#designationModel',
                    'id': 'addDesignation',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#saveDesignation').html("Save Designation");
                    $('#designation_id').val('');
                    $('#last_row').val(0);
                    $('.department_error').text('');
                    $('.designation_error').text('');
                    $('#designationForm').trigger("reset");
                    $("#designationForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Designation");
                    $('#designationModel').modal('show');
                }
            }],


        });

        $('#saveDesignation').click(function(e) {
            if ($("#designation_id").val() == null || $("#designation_id").val() == "") {
                storeDesignation(this);
            }
        });
        $('#updateDesignation').click(function(e) {
            if ($("#designation_id").val() != null || $("#designation_id").val() != "") {

                updateDesignation(this);
            }
        });

        function storeDesignation($this) {
            var button = $($this);
            sending(button);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#designationForm').serialize(),
                url: "{{ route('designations.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#designationForm').trigger("reset");
                        $('#designationModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    } else {
                        showToast('error', response.msg);
                    }
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    // Clear previous errors
                    $('.designation_error').text('');
                    $('.department_error').text('');
                    // Iterate over each table row
                    $('#designationTable tbody tr ').each(function(index) {
                        const $row = $(this);
                        department_name = $row.find('#department_id_' + index).val();
                        const dpt_error = $row.find('.department_error');
                        const des_error = $row.find('.designation_error');
                        // Check if there are any errors for the specific row's department_name
                        if (errors['department_id_.' + index]) {
                            dpt_error.html(errors['department_id_.' + index][0]);
                        } else {
                            dpt_error.html('');
                        }
                        // Check if there are any errors for the specific row's designation_name
                        if (errors['designation_name_.' + index]) {
                            des_error.html(errors['designation_name_.' + index][0]);
                        } else {
                            des_error.html('');
                        }
                    });
                    sending(button, true);
                }

            });
        }

        function updateDesignation($this) {
            var button = $($this);
            sending(button);
            let url = $('meta[name=app-url]').attr("content") + "/designations/" + $("#designation_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#designationUpdateForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#designationForm').trigger("reset");
                        $('#designationUpdateModel').modal('hide');
                        table.draw();
                        showToast('success', response.msg);
                    } else {
                        showToast('error', response.msg);
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    sending(button, true);
                }
            });
        }
        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('designations.index') }}" + '/' + id + '/edit', function(data) {
                $('.designation_name_error').text('');
                $('.department_id_error').text('');
                $('#updateDesignation').html("Update Designation");
                $('#modelUpdateHeading').html("Update Designation");
                $('#designationUpdateModel').modal('show');
                $('#designation_id').val(data.id);
                $('#designation_name').val(data.designation_name);
                $('#department_id').val(data.department_id);

            });
        });



        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteDesignation(id);
            });
        });

        function deleteDesignation(id) {
            var url = "{{ route('designations.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('designations.index') }}" + '/' + id, function(data) {
                $('#showDesignationModal').modal('show');
                $('#designationShowForm #department_id').val(data.department_id);
                $('#designationShowForm #designation_name').val(data.designation_name);
            });
        });
        //adding row
        $(document).ready(function() {
            // Add Row button click event
            $('#addRowDesignation').click(function(event) {
                event.preventDefault();
                updateDesignationList(0, 'A'); // Call the addRow function to add a new row
            });

            var departments = @json($departments);

            // Add or Delete Row function
            function updateDesignationList(currentRow, cType) {
                var count = parseInt($('#last_row').val(), 10);
                count = count + 1;
                if (cType === 'A' && count <= 9) {
                    var options = '<option value="">Select Department</option>';
                    departments.forEach(function(department) {
                        options += `<option value="${department.id}">${department.department_name}</option>`;
                    });
                    var html = `
                        <tr id="row_${count}">
                            <td class="slno">${count + 1}</td>
                            <td>
                                <select class="form-select form-select-sm department" name="department_id_[]" id="department_id_${count}">
                                    ${options}
                                </select>
                                <span class="text-danger error-text department_error"></span>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm designation" name="designation_name_[]" id="designation_name_${count}">
                                <span class="text-danger error-text designation_error"></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-danger deleteRow" data-row="${count}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`;

                    $('#last_row').val(count);
                    $('#designationTable tbody').append(html);
                    updateRowIds(); // Update the row numbers after adding
                }
                else if(cType === 'A' && count > 9){
                    alert('Maximum 10 rows allowed.');
                }

                if (cType === 'D') {
                    if (currentRow > 0) { // Ensure the default row is not deleted
                        var trId = "#row_" + currentRow;
                        $(trId).remove(); // Remove the row using jQuery
                        updateRowIds(); // Update the row numbers and last_row value
                    } else {
                        alert("Default row cannot be deleted");
                    }
                }
            }

            // Update Row IDs and Serial Numbers function
            function updateRowIds() {
                var nCtr = 1; // Start counting from 1 for row IDs
                $('#designationTable tbody tr').each(function(index) {
                    if (!$(this).hasClass('default-row')) {
                        var newRowId = 'row_' + nCtr;
                        $(this).attr('id', newRowId); // Update the row ID
                        $(this).find('.deleteRow').data('row', nCtr); // Update the delete button's data-row attribute
                        $(this).find('td:eq(0)').html(nCtr + 1); // Update the serial number (start from 2 for non-default rows)
                        nCtr++;
                    } else {
                        $(this).find('td:eq(0)').html(1); // Default row serial number is always 1
                    }
                });
                $('#last_row').val(nCtr - 1); // Update the last_row input with the new count
            }

            // Handle delete row button click event
            $('#designationTable').on('click', '.deleteRow', function() {
                var rowId = $(this).data('row');
                updateDesignationList(rowId, 'D'); // Call addRow function to delete the specific row
            });
        });

    });
</script>
