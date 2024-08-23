<script type="text/javascript">
    $(function () {

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
                url: "{{ route('adjustment_types.list') }}",
                data: function (d) {
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
            }
        });
        $('#createAdjustmentType').click(function () {
            $('.adjustment_type_error').html('');
            $('#savedata').html("Save Adjustment Type");
            $('#adjustment_type_id').val('');
            $('#adjustmentTypeForm').trigger("reset");
            $('#modelHeading').html("Create New Adjustment Type");
            $('#adjustmentTypeModel').modal('show');
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
                        table.draw();
                        var successMessage = type === 'POST' ? 'Adjustment Type Added Successfully!' : 'Adjustment Type Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
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
                    if (response.status === "success") {
                        table.draw();
                        showSuccessMessage('Deleted!', 'Adjustment Type Deleted Successfully!');
                    } else {
                        showError('Deleted!', response.msg);
                    }
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

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
