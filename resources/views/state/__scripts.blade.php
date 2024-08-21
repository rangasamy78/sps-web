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
                url: "{{ route('states.list') }}",
                data: function (d) {
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
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createState').click(function () {
            $('#savedata').val("create-state");
            $('#savedata').html("Save State");
            $('#state_id').val('');
            $('#stateForm').trigger("reset");
            $('.name_error').html('');
            $('#modelHeading').html("Create New State");
            $('#stateModel').modal('show');
        });

        $('#stateForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            if($("#state_id").val() == null || $("#state_id").val() == "")
            {
                storeState();
            } else {
                updateState();
            }
        });

        function storeState()
        {
            $(this).html('Sending..');
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#stateForm').serialize(),
                url: "{{ route('states.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    if(response.status == "success"){
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
                    $('#savedata').html('Save State');
                }
            });
        }

        function updateState()
        {
            $(this).html('Sending..');
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
                    if(response.status == "success"){
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
                    console.log('Error:', data);
                    $('#savedata').html('Update State');
                }
            });
        }

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('states.index') }}" +'/' + id +'/edit', function (data) {
                $(".name_error").html("");
                $('#modelHeading').html("Edit State");
                $('#savedata').val("edit-state");
                $('#savedata').html("Update State");
                $('#stateModel').modal('show');
                $('#state_id').val(data.id);
                $('#name').val(data.name);
                $('#code').val(data.code);
            });
        });


        $('body').on('click', '.deletebtn', function (e) {
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
                            if(response.status == "success"){
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

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('states.index') }}" +'/' + id, function (data) {
                $('#modelHeading').html("Show State");
                $('#savedata').val("show-state");
                $('#showStatemodal').modal('show');
                $('#showStateForm #name').val(data.name);
                $('#showStateForm #code').val(data.code);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
