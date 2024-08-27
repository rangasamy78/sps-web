<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#calculateMeasurementLabelFilter').on('keyup change', function(e) {
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
                url: "{{ route('calculate_measurement_labels.list') }}",
                data: function(d) {
                    d.calculate_measurement_label_search = $('#calculateMeasurementLabelFilter').val();
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
                    data: 'label_name',
                    name: 'label_name'
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
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Calculate Measurement Label</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#calculateMeasurementLabelModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#savedata').html("Save Calculate Measurement Label");
                    $('#label_name_id').val('');
                    $('#calculateMeasurementLabelForm').trigger("reset");
                    $(".label_name_error").html("");
                    $('#modelHeading').html("Create New Calculate Measurement Label");
                    $('#calculateMeasurementLabelModel').modal('show');
                }
            }],
        });

        $('#calculateMeasurementLabelForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#label_name_id').val() ? "{{ route('calculate_measurement_labels.update', ':id') }}".replace(':id', $('#label_name_id').val()) : "{{ route('calculate_measurement_labels.store') }}";
            var type = $('#label_name_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#calculateMeasurementLabelForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#calculateMeasurementLabelForm').trigger("reset");
                        $('#calculateMeasurementLabelModel').modal('hide');
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
            $('.label_name_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('calculate_measurement_labels.index') }}" + '/' + id + '/edit', function(data) {
                $(".label_name_code_error").html("");
                $('#modelHeading').html("Edit Calculate Measurement Label");
                $('#savedata').val("edit-calculate-measurement-label");
                $('#savedata').html("Update Calculate Measurement Label");
                $('#calculateMeasurementLabelModel').modal('show');
                $('#label_name_id').val(data.id);
                $('#label_name').val(data.label_name);
            });
        });
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
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
                success: function(response) {
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
            $.get("{{ route('calculate_measurement_labels.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Calculate Measurement Label");
                $('#showCalculateMeasurementLabelModal').modal('show');
                $('#showCalculateMeasurementLabelForm #label_name').val(data.label_name);
            });
        });
    });
</script>