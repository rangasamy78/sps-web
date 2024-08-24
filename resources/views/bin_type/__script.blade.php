<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#binTypeTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('bintypes.list') }}",
                data: function(d) {
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
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Bin Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#binTypeModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#savedata').html("Save Bin Type");
                    $('#bintype_id').val('');
                    $('#binTypeForm').trigger("reset");
                    $(".bin_type_error").html("");
                    $('#modelHeading').html("Create New Bin Type");
                    $('#binTypeModel').modal('show');
                }
            }],
        });

        $('#bin_type').on('input', function() {
            $('.bin_type_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#bintype_id').val() ? "{{ route('bin_types.update', ':id') }}".replace(':id', $('#bintype_id').val()) : "{{ route('bin_types.store') }}";
            var type = $('#bintype_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#binTypeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#binTypeForm').trigger("reset");
                        $('#binTypeModel').modal('hide');
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
            var id = $(this).data('id');
            $(".bin_type_error").html("");
            $.get("{{ route('bin_types.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Bin Type");
                $('#savedata').val("edit-bin-type");
                $('#savedata').html("Update Bin Type");
                $('#binTypeModel').modal('show');
                $('#bintype_id').val(data.id);
                $('#bin_type').val(data.bin_type);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteBinType(id);
            });
        });
        function deleteBinType(id) {
            var url = "{{ route('bin_types.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
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
            $.get("{{ route('bin_types.index') }}" + '/' + id, function(data) {
                $('#show-binType-modal').modal('show');
                $('#binTypeShowForm #bin_type').val(data.bin_type);
            });
        });

    });
</script>
