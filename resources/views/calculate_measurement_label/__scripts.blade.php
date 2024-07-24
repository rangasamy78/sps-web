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
                url: "{{ route('calculate_measurement_labels.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'label_name', name: 'label_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createCalculateMeasurementLabel').click(function () {
            $('.label_name_error').html('');
            $('#savedata').html("Save Calculate Measurement Label");
            $('#label_name_id').val('');
            $('#calculateMeasurementLabelForm').trigger("reset");
            $('#modelHeading').html("Create New Calculate Measurement Label");
            $('#calculateMeasurementLabelModel').modal('show');
        });
        $('#calculateMeasurementLabelForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#label_name_id').val() ? "{{ route('calculate_measurement_labels.update', ':id') }}".replace(':id', $('#label_name_id').val()) : "{{ route('calculate_measurement_labels.store') }}";
            var type = $('#label_name_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#calculateMeasurementLabelForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#calculateMeasurementLabelForm').trigger("reset");
                        $('#calculateMeasurementLabelModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Calculate Measurement Label Added Successfully!' : 'Calculate Measurement Label Updated Successfully!';
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
            $('.label_name_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('calculate_measurement_labels.index') }}" + '/' + id + '/edit', function (data) {
                $(".label_name_code_error").html("");
                $('#modelHeading').html("Edit Calculate Measurement Label");
                $('#savedata').val("edit-calculate-measurement-label");
                $('#savedata').html("Update Calculate Measurement Label");
                $('#calculateMeasurementLabelModel').modal('show');
                $('#label_name_id').val(data.id);
                $('#label_name').val(data.label_name);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteCalculateMeasurementLabel(id);
            });
        });
        function deleteCalculateMeasurementLabel(id) {
            var url = "{{ route('calculate_measurement_labels.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Calculate Measurement Label Deleted Successfully!');
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
            $.get("{{ route('calculate_measurement_labels.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Calculate Measurement Label");
                $('#showCalculateMeasurementLabelModal').modal('show');
                $('#showCalculateMeasurementLabelForm #label_name').val(data.label_name);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
