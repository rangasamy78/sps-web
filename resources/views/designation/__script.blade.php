<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#createDesignation').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('designations.list') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
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
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(index + 1); // Update the index column with the correct row index
            },
            columnDefs: [{
                targets: -1,
                orderable: false
            }],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            // displayLength: 7,
            // lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [{
                    extend: 'collection',
                    className: 'btn btn-label-primary dropdown-toggle me-2',
                    text: '<i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [{
                            extend: 'print',
                            text: '<i class="bx bx-printer me-1"></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            },
                            customize: function(win) {
                                $(win.document.body)
                                    .css('color', '#333')
                                    .css('background-color', '#fff');
                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('color', 'inherit')
                                    .css('border-color', 'inherit')
                                    .css('background-color', 'inherit');
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="bx bx-file me-1"></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="bx bxs-file-export me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            text: '<i class="bx bx-copy me-1"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: ':visible',
                                format: {
                                    body: function(data, row, column, node) {
                                        return node.textContent || node.innerText;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Record</span>',
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
                        $('.department_error').text('');
                        $('.designation_error').text('');
                        $('#designationForm').trigger("reset");
                        $("#designationForm").find("tr:gt(1)").remove();
                        $('#modelHeading').html("Create New Designation");
                        $('#designationModel').modal('show');
                        // updateRowIds();
                    }
                }
            ],


        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
                '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
                '30px');
        }, 300);

        $('#saveDesignation').click(function(e) {
            if ($("#designation_id").val() == null || $("#designation_id").val() == "") {
                storeDesignation();
            }
        });
        $('#updateDesignation').click(function(e) {
            if ($("#designation_id").val() != null || $("#designation_id").val() != "") {

                updateDesignation();
            }
        });

        function storeDesignation() {
            $(this).html('Sending..');
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
                        table.draw();
                        Swal.fire({
                            title: 'Created!',
                            text: 'Designation Added Successfully!',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.msg,
                            icon: response.status,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        });
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
                }

            });
        }

        function updateDesignation() {
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
                        Swal.fire({
                            title: 'Updated!',
                            text: 'Designation Updated Successfully!',
                            type: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Updated!',
                            text: response.msg,
                            type: response.status,
                            customClass: {
                                confirmButton: 'btn btn-danger'
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
                    $('#updateDesignation').html('Update Designation');
                }
            });
        }
        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('designations.index') }}" + '/' + id + '/edit', function(data) {
                $('.designation_name_error').text('');
                $('.department_id_error').text('');
                $('#modelUpdateHeading').html("Update Designation");
                $('#designationUpdateModel').modal('show');
                $('#designation_id').val(data.id);
                $('#designation_name').val(data.designation_name);
                $('#department_id').val(data.department_id);

            });
        });


        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            let url = $('meta[name=app-url]').attr("content") + "/designations/" + id;
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
                            if (response.status == "success") {
                                table.draw();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Designation Deleted Successfully!',
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
                addRow(0, 'A'); // Call the addRow function to add a new row
            });

            var departments = @json($departments);

            // Add or Delete Row function
            function addRow(currentRow, cType) {
                if (cType === 'A') {
                    var count = parseInt($('#lastrow').val(), 10);
                    count = count + 1;
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
                
                    $('#lastrow').val(count);
                    $('#designationTable tbody').append(html);
                    updateRowIds(); // Update the row numbers after adding
                }

                if (cType === 'D') {
                    if (currentRow > 0) { // Ensure the default row is not deleted
                        var trId = "#row_" + currentRow;
                        $(trId).remove(); // Remove the row using jQuery
                        updateRowIds(); // Update the row numbers and lastrow value
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
                        // alert(newRowId);
                        $(this).attr('id', newRowId); // Update the row ID
                        $(this).find('.deleteRow').data('row', nCtr); // Update the delete button's data-row attribute
                        $(this).find('td:eq(0)').html(nCtr + 1); // Update the serial number (start from 2 for non-default rows)
                        nCtr++;
                    } else {
                        $(this).find('td:eq(0)').html(1); // Default row serial number is always 1
                    }
                });
                $('#lastrow').val(nCtr - 1); // Update the lastrow input with the new count
            }

            // Handle delete row button click event
            $('#designationTable').on('click', '.deleteRow', function() {
                var rowId = $(this).data('row');
                addRow(rowId, 'D'); // Call addRow function to delete the specific row
            });
        });

    });
</script>