<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#stateNameFilter, #stateCodeFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('states.list') }}",
                data: function(d) {
                    d.state_name_search = $('#stateNameFilter').val();
                    d.state_code_search = $('#stateCodeFilter').val();
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
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add State</span>',
                    className: 'create-new btn btn-primary me-2',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#stateModel'
                    },
                    action: function(e, dt, node, config) {
                        $('#savedata').val("create-state");
                        $('#savedata').html("Save State");
                        $('#state_id').val('');
                        $('#stateForm').trigger("reset");
                        resetForm()
                        $('#modelHeading').html("Create New State");
                        $('#stateModel').modal('show');
                    }
                },
                {
                    text: '<i class="bx bx-upload me-sm-1"></i> <span class="d-none d-sm-inline-block">Import State</span>',
                    className: 'import-state btn btn-primary me-2',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#importStateModal'
                    },
                    action: function(e, dt, node, config) {
                        $('#importStateModal').modal('show');
                        $('#importStateForm').trigger("reset");
                    }
                },
                {
                    text: '<i class="bx bx-download bx-sm"></i>',
                    className: 'download-template btn btn-primary btn-sm',
                    attr: {
                        'data-bs-toggle'  : 'tooltip',
                        'data-bs-placement'  : 'top',
                        'title'  : 'State template',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('state.template_download') }}";
                    }
                }
            ]
        });

        $('#stateForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            if ($("#state_id").val() == null || $("#state_id").val() == "") {
                storeState(this);
            } else {
                updateState(this);
            }
        });

        function storeState($this) {
            var button = $($this);
            sending(button);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#stateForm').serialize(),
                url: "{{ route('states.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#stateForm').trigger("reset");
                        $('#stateModel').modal('hide');
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
                    sending(button, true);
                }
            });
        }

        function updateState($this) {
            var button = $($this);
            sending(button);
            let url = $('meta[name=app-url]').attr("content") + "/states/" + $("#state_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#stateForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#stateForm').trigger("reset");
                        $('#stateModel').modal('hide');
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
                    sending(button, true);
                }
            });
        }

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('states.index') }}" + '/' + id + '/edit', function(data) {
                resetForm()
                $('#modelHeading').html("Edit State");
                $('#savedata').val("edit-state");
                $('#savedata').html("Update State");
                $('#stateModel').modal('show');
                $('#state_id').val(data.id);
                $('#name').val(data.name);
                $('#code').val(data.code);
            });
        });

        function resetForm() {
            $(".name_error").html("");
            $(".code_error").html("");
        }

        $('body').on('click', '.deletebtn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            let url = $('meta[name=app-url]').attr("content") + "/states/" + id;
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
                                showToast('success', response.msg);
                                table.draw();
                            } else {
                                showToast('error', response.msg);
                            }
                        },
                        error: function(response) {
                            console.log(response.responseJSON);
                            showToast('error', response.msg);
                        }
                    });
                }
            });
        });

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('states.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show State");
                $('#savedata').val("show-state");
                $('#showStateModal').modal('show');
                $('#showStateForm #name').val(data.name);
                $('#showStateForm #code').val(data.code);
            });
        });
    });

    $(document).ready(function() {

        $('#importStateModal').on('show.bs.modal', function() {
            $('#file').val('');
            $('span.file_error').text('');
        });

        $('#importStateForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);
            let table = $('#datatable').DataTable();

            $.ajax({
                url: '{{ route("states.import") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#importStateForm').trigger("reset");
                    $('#importStateModal').modal('hide');
                    table.draw();

                    let message = '';
                    let icon = 'success';

                    if (response.status === "success") {
                        message = 'File uploaded and processed successfully!';
                    } else if (response.status === "warning") {
                        message = 'File processed with some issues:<br><br>';
                        icon = 'warning';
                        response.errors.forEach(function(error) {
                            message += '<span style="display: block; text-align: left; margin-bottom: 4px; padding: 2px;  #ccc; background-color: #f9f9f9;">' + error + '</span>';
                        });
                    }

                    Swal.fire({
                        title: response.status.charAt(0).toUpperCase() + response.status.slice(1) + '!',
                        html: message,
                        icon: icon,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                }
            });
        });

        $('#downloadState').on('click', function() {
            window.location.href = "{{ route('state.template_download') }}";
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
