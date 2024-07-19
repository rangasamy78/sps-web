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
            ajax: "{{ route('sub_headings.list') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                }, // Row index column
                {
                    data: 'sub_heading_name',
                    name: 'sub_heading_name'
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
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
                '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
                '30px');
        }, 300);

        $('#createSubHeading').click(function () {
            $('#savedata').val("create-Subheading");
            $('#subheading_id').val('');
            $('#subHeadingForm').trigger("reset");
            $('#modelHeading').html("Create New Sub Heading");
            $('#subHeadingModel').modal('show');
        });


        $('#savedata').click(function (e) {
            e.preventDefault();
            if($("#subheading_id").val() == null || $("#subheading_id").val() == "")
            {
                storeSubheading();
            } else {
                updateSubheading();
            }
        });

        function storeSubheading()
        {
            $(this).html('Sending..');
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: $('#subHeadingForm').serialize(),
                url: "{{ route('sub_headings.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    if(response.status == "success"){
                        $('#subHeadingForm').trigger("reset");
                        $('#subHeadingModel').modal('hide');
                        $(".sub_heading_name_error").html("");
                        table.draw();
                        Swal.fire({
                            title: 'Created!',
                            text: 'Sub Heading Added Successfully!',
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
                    $('#savedata').html('Save Sub Heading');
                }
            });
        }
        function updateSubheading()
        {
            $(this).html('Sending..');
            let url = $('meta[name=app-url]').attr("content") + "/sub_headings/" + $("#subheading_id").val();           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: $('#subHeadingForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if(response.status == "success"){
                        $('#subHeadingForm').trigger("reset");
                        $('#subHeadingModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: 'Updated!',
                            text: 'Sub Heading Updated Successfully!',
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
                    $('#savedata').html('Update Sub Heading');
                }
            });
        }

        

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('sub_headings.index') }}" +'/' + id +'/edit', function (data) {
                $(".sub_heading_name_error").html("");
                $('#modelHeading').html("Edit Sub Heading");
                $('#savedata').val("edit-user");
                $('#savedata').html("Update Sub Heading");
                $('#subHeadingModel').modal('show');
                $('#subheading_id').val(data.id);
                $('#sub_heading_name').val(data.sub_heading_name);
            });
        });


        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            let url = $('meta[name=app-url]').attr("content") + "/sub_headings/" + id;
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
                                    text: 'Sub Heading Deleted Successfully!',
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
            $.get("{{ route('sub_headings.index') }}" +'/' + id, function (data) {
                $(".sub_heading_name_error").html("");
                $('#modelHeading').html("Show Subheading");
                $('#savedata').val("edit-user");
                $('#showsubHeadingmodal').modal('show');
                $('#subHeadingShowForm #sub_heading_name').val(data.sub_heading_name);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);

    });
</script>
