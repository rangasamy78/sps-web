<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#unitMeasureNameFilter, #unitMeasureEntityFilter').on('keyup change', function(e) {
                e.preventDefault();
                table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('unit_measures.list') }}",
                data: function (d) {
                    d.unit_measure_entity_search = $('#unitMeasureEntityFilter').val();
                    d.unit_measure_name_search = $('#unitMeasureNameFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'unit_measure_entity', name: 'unit_measure_entity' },
                { data: 'unit_measure_name', name: 'unit_measure_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createUnitMeasure').click(function () {
            resetForm();
            $('#savedata').html("Save Unit Measure");
            $('#unit_measure_id').val('');
            $('#unitMeasureForm').trigger("reset");
            $('#modelHeading').html("Create New Unit of Measure");
            $('#unitMeasureModel').modal('show');
        });

        $('#unitMeasureForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#unitMeasureForm input, #unitMeasureForm select').on('input change', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#unit_measure_id').val() ? "{{ route('unit_measures.update', ':id') }}".replace(':id', $('#unit_measure_id').val()) : "{{ route('unit_measures.store') }}";
            var type = $('#unit_measure_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#unitMeasureForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#unitMeasureForm').trigger("reset");
                        $('#unitMeasureModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                        var successMessage = type === 'POST' ? 'Unit Measure Added Successfully!' : 'Unit Measure Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });
        $('body').on('click', '.editbtn', function () {
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('unit_measures.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit Unit of Measure");
                $('#unitMeasureModel').modal('show');
                $('#savedata').val("edit-unit-measure");
                $('#savedata').html("Update Unit Measure");
                $('#unit_measure_id').val(data.id);
                $('#unit_measure_entity').val(data.unit_measure_entity);
                $('#unit_measure_name').val(data.unit_measure_name);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteUnitMeasure(id);
            });
        });
        function deleteUnitMeasure(id) {
            var url = "{{ route('unit_measures.destroy', ':id') }}".replace(':id', id);
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
                        showSuccessMessage('Deleted!', 'Unit Measure Deleted Successfully!');
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
            $.get("{{ route('unit_measures.index') }}" + '/' + id, function (data) {
                $('#showUnitMeasureModal').modal('show');
                $('#showUnitMeasureForm #unit_measure_entity').val(data.unit_measure_entity);
                $('#showUnitMeasureForm #unit_measure_name').val(data.unit_measure_name);
            });
        });
    });

    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
        $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
    }, 300);

    function resetForm() {
        $('.unit_measure_entity_error').html('');
        $('.unit_measure_name_error').html('');
    }
</script>
