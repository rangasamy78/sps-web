<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#adjustmentTypeFilter').on('keyup change', function(e) {
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
                url: "{{ route('adjustment_types.list') }}",
                data: function (d) {
                    d.adjustment_type_search = $('#adjustmentTypeFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'adjustment_type', name: 'adjustment_type' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Adjustment Type</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#adjustmentTypeModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {

                        $('#savedata').html("Save Adjustment Type");
                        $('#adjustment_type_id').val('');
                        $('#adjustmentTypeForm').trigger("reset");
                        $('.adjustment_type_error').html('');
                        $('#modelHeading').html("Create New Adjustment Type");
                        $('#adjustmentTypeModel').modal('show');
                    }
                }
            ],
        });
       
        $('#adjustmentTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#adjustment_type_id').val() ? "{{ route('adjustment_types.update', ':id') }}".replace(':id', $('#adjustment_type_id').val()) : "{{ route('adjustment_types.store') }}";
            var type = $('#adjustment_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#adjustmentTypeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#adjustmentTypeForm').trigger("reset");
                        $('#adjustmentTypeModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });
        $('body').on('click', '.editbtn', function () {
            $('.adjustment_type_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('adjustment_types.index') }}" + '/' + id + '/edit', function (data) {
                $(".adjustment_type_error").html("");
                $('#modelHeading').html("Edit Adjustment Type");
                $('#savedata').val("edit-adjustment-type");
                $('#savedata').html("Update Adjustment Type");
                $('#adjustmentTypeModel').modal('show');
                $('#adjustment_type_id').val(data.id);
                $('#adjustment_type').val(data.adjustment_type);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteAdjustmentType(id);
            });
        });
        function deleteAdjustmentType(id) {
            var url = "{{ route('adjustment_types.destroy', ':id') }}".replace(':id', id);
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
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('adjustment_types.index') }}" + '/' + id, function (data) {
                $('#showAdjustmentTypeModal').modal('show');
                $('#showAdjustmentTypeForm #adjustment_type').val(data.adjustment_type);

            });
        });
       
    });

</script>
