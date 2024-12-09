<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#termTypeNameFilter,#typeIdFilter').on('keyup change', function(e) {
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
                url: "{{ route('term_types.list') }}",
                data: function(d) {
                    d.term_type_name_search = $('#termTypeNameFilter').val();
                    d.type_id_search = $('#typeIdFilter').val();
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
                    data: 'term_type_name',
                    name: 'term_type_name',
                },
                {
                    data: 'type_id',
                    name: 'type_id',
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Term Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#termTypeModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').val("create-term-type");
                    $('#savedata').html("Save Term Type");
                    $('#term_type_id').val('');
                    $('#termTypeForm').trigger("reset");
                    $('.term_type_name_error').html('');
                    $('#modelHeading').html("Create New Term Type");
                    $('#termTypeModel').modal('show');
                }
            }],
        });

        $('#termTypeForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            if ($("#term_type_id").val() == null || $("#term_type_id").val() == "") {
                storeTermType(this);
            } else {
                updateTermType(this);
            }
        });

        function storeTermType($this) {
            var button = $($this);
            sending(button);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#termTypeForm').serialize(),
                url: "{{ route('term_types.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#termTypeForm').trigger("reset");
                        $('#termTypeModel').modal('hide');
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
                    sending(button, true);
                }
            });
        }

        function updateTermType($this) {
            var button = $($this);
            sending(button);
            let url = $('meta[name=app-url]').attr("content") + "/term_types/" + $("#term_type_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#termTypeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#termTypeForm').trigger("reset");
                        $('#termTypeModel').modal('hide');
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
                    sending(button, true);
                }
            });
        }

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('term_types.index') }}" + '/' + id + '/edit', function(data) {
                $(".term_type_name_error").html("");
                $('#modelHeading').html("Edit Term Type");
                $('#savedata').val("edit-term-type");
                $('#savedata').html("Update Term Type");
                $('#termTypeModel').modal('show');
                $('#term_type_id').val(data.id);
                $('#term_type_name').val(data.term_type_name);
                $('#type_id').val(data.type_id);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            let url = $('meta[name=app-url]').attr("content") + "/term_types/" + id;
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
            $.get("{{ route('term_types.index') }}" + '/' + id, function(data) {
                $('#showTermTypemodal').modal('show');
                $('#showTermTypeForm #term_type_name').val(data.term_type_name);
                $('#showTermTypeForm #type_id').val(data.type_id);
            });
        });
    });
</script>
