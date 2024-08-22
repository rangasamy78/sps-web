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
                url: "{{ route('account_types.list') }}",
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
                    data: 'account_type_name',
                    name: 'account_type_name',
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

        $('#createAccountType').click(function () {
            $('#savedata').val("create-account-type");
            $('#savedata').html("Save Account Type");
            $('#account_type_id').val('');
            $('#account_typeForm').trigger("reset");
            $('.account_type_name_error').html('');
            $('#modelHeading').html("Create New Account Type");
            $('#accountTypeModel').modal('show');
        });

        $('#accountTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            if($("#account_type_id").val() == null || $("#account_type_id").val() == "")
            {
                storeAccountType();
            } else {
                updateAccountType();
            }
        });

        function storeAccountType()
        {
            $(this).html('Sending..');
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#accountTypeForm').serialize(),
                url: "{{ route('account_types.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    if(response.status == "success"){
                        $('#accountTypeForm').trigger("reset");
                        $('#accountTypeModel').modal('hide');
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
                    $('#savedata').html('Save Account Type');
                }
            });
        }

        function updateAccountType()
        {
            $(this).html('Sending..');
            let url = $('meta[name=app-url]').attr("content") + "/account_types/" + $("#account_type_id").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#accountTypeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(response.status == "success"){
                        $('#accountTypeForm').trigger("reset");
                        $('#accountTypeModel').modal('hide');
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
                    console.log('Error:', data);
                    $('#savedata').html('Update Account Type');
                }
            });
        }

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('account_types.index') }}" +'/' + id +'/edit', function (data) {
                $(".account_type_name_error").html("");
                $('#modelHeading').html("Edit Account Type");
                $('#savedata').val("edit-account-type");
                $('#savedata').html("Update Account Type");
                $('#accountTypeModel').modal('show');
                $('#account_type_id').val(data.id);
                $('#account_type_name').val(data.account_type_name);
            });
        });


        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            let url = $('meta[name=app-url]').attr("content") + "/account_types/" + id;
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

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('account_types.index') }}" +'/' + id, function (data) {
                $('#showAccountTypemodal').modal('show');
                $('#showAccountTypeForm #account_type_name').val(data.account_type_name);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
