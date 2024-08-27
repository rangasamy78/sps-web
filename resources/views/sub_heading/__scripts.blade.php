<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#subHeadingNameFilter').on('keyup change', function(e) {
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
                url: "{{ route('sub_headings.list') }}",
                data: function (d) {
                    d.sub_heading_name_search = $('#subHeadingNameFilter').val();
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
                    data: 'sub_heading_name',
                    name: 'sub_heading_name'
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
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Sub Heading</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#subHeadingModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {
                        $('#savedata').html("Save New Sub Heading");
                        $('#sub_heading_id').val('');
                        $('#subHeadingForm').trigger("reset");
                        $('.sub_heading_name_error').html('');
                        $('#modelHeading').html("Create New Sub Heading");
                        $('#subHeadingModel').modal('show');
                    }
                }
            ],
        });

        $('#subHeadingForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })

        $('#createSubHeading').click(function () {
            $('.sub_heading_name_error').html('');
            $('#savedata').html("Create Sub Heading");
            $('#sub_heading_id').val('');
            $('#subHeadingForm').trigger("reset");
            $('#modelHeading').html("Create New Sub Heading");
            $('#subHeadingModel').modal('show');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#sub_heading_id').val() ? "{{ route('sub_headings.update', ':id') }}".replace(':id', $('#sub_heading_id').val()) : "{{ route('sub_headings.store') }}";
            var type = $('#sub_heading_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#subHeadingForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#subHeadingForm').trigger("reset");
                        $('#subHeadingModel').modal('hide');
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

        $('body').on('click', '.editbtn', function () {
            $('.sub_heading_name_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('sub_headings.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Edit Sub Heading");
                $('#savedata').val("edit-sub-heading");
                $('#savedata').html("Update Sub Heading");
                $('#subHeadingModel').modal('show');
                $('#sub_heading_id').val(data.id);
                $('#sub_heading_name').val(data.sub_heading_name);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSubHeading(id);
            });
        });

        function deleteSubHeading(id) {
            var url = "{{ route('sub_headings.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table);
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('sub_headings.index') }}" + '/' + id, function(data) {
                $('#showSubHeadingModal').modal('show');
                $('#showSubHeadingForm #sub_heading_name').val(data.sub_heading_name);
            });
        });
    });
</script>