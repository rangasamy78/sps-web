<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#binTypeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('bintypes.list') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                   
                },{
                    data: 'bin_type',
                    name: 'bin_type'
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
                        'data-bs-target': '#binTypeModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {
                        // Custom action for Add New Record button
                        $('#saveBinType').val("create-bin");
                        $('#bintype_id').val('');
                        $('#binTypeForm').trigger("reset");
                        $(".bin_type_error").html("");
                        $('#modelHeading').html("Create New Bin Type");
                        $('#binTypeModel').modal('show');
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

        $('#saveBinType').click(function(e) {
            let v = $("#bintype_id").val();
            e.preventDefault();
            if ($("#bintype_id").val() == null || $("#bintype_id").val() == "") {
                storeBinType();
            } else {
                updateBinType();
            }
        });
        $('#bin_type').on('input', function() {
            $('.bin_type_error').text('');
        });

        function storeBinType() {
            $(this).html('Sending..');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#binTypeForm').serialize(),
                url: "{{ route('bin_types.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#binTypeForm').trigger("reset");
                        $('#binTypeModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: 'Created!',
                            text: 'Bin Type Added Successfully!',
                            type: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
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
                    $('#saveBinType').html('Save Bin Type');
                }
            });
        }

        function updateBinType() {
            $(this).html('Sending..');
            let url = $('meta[name=app-url]').attr("content") + "/bin_types/" + $("#bintype_id").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#binTypeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#binTypeForm').trigger("reset");
                        $('#binTypeModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: 'Updated!',
                            text: 'Bin Type Updated Successfully!',
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
                    console.log('Error:', data);
                    $('#savedata').html('Update Bin Type');
                }
            });
        }

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $(".bin_type_error").html("");
            $.get("{{ route('bin_types.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Bin Type");
                $('#saveBinType').val("edit-bin-type");
                $('#saveBinType').html("Update Bin Type");
                $('#binTypeModel').modal('show');
                $('#bintype_id').val(data.id);
                $('#bin_type').val(data.bin_type);
            });
        });


        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            let url = $('meta[name=app-url]').attr("content") + "/bin_types/" + id;
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
                                    text: 'Bin Type Deleted Successfully!',
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
            $.get("{{ route('bin_types.index') }}" + '/' + id, function(data) {
                $(".name_error").html("");
                $('#show-binType-modal').modal('show');
                $('#binTypeShowForm #bin_type').val(data.bin_type);
            });
        });

    });
</script>