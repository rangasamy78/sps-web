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
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('unit_measures.list') }}",
                data: function(d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.unit_measure_name_search   = $('#unitMeasureNameFilter').val();
                    d.unit_measure_entity_search = $('#unitMeasureEntityFilter').val();
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
                    data: 'unit_measure_entity',
                    name: 'unit_measure_entity'
                },
                {
                    data: 'unit_measure_name',
                    name: 'unit_measure_name'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Unit of Measure</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#unitMeasureModel',
                },
                action: function(e, dt, node, config) {
                    resetForm();
                    $('#savedata').html("Save Unit Measure");
                    $('#unit_measure_id').val('');
                    $('#unit_measure_entity').val('').trigger('change');
                    $('#unitMeasureForm').trigger("reset");
                    $('#modelHeading').html("Create New Unit of Measure");
                    $('#unitMeasureModel').modal('show');
                }
            }],
        });

        $('#unitMeasureEntityFilter').select2({
            placeholder: 'Select Unit of Measure Entity',
            dropdownParent: $('#unitMeasureEntityFilter').parent()
        });

        $('#unit_measure_entity').select2({
            placeholder: 'Select Unit of Measure Entity',
            dropdownParent: $('#unit_measure_entity').parent()
        });

        $('#unitMeasureForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#unitMeasureForm input, #unitMeasureForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
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
                success: function(response) {
                    if (response.status == "success") {
                        $('#unitMeasureForm').trigger("reset");
                        $('#unitMeasureModel').modal('hide');
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
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('unit_measures.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Edit Unit of Measure");
                $('#unitMeasureModel').modal('show');
                $('#savedata').val("edit-unit-measure");
                $('#savedata').html("Update Unit Measure");
                $('#unit_measure_id').val(data.id);
                $('#unit_measure_entity').val(data.unit_measure_entity).trigger('change');
                $('#unit_measure_name').val(data.unit_measure_name);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
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
            $.get("{{ route('unit_measures.index') }}" + '/' + id, function(data) {
                $('#showUnitMeasureModal').modal('show');
                $('#showUnitMeasureForm #unit_measure_entity').val(data.unit_measure_entity);
                $('#showUnitMeasureForm #unit_measure_name').val(data.unit_measure_name);
            });
        });

        function resetForm() {
            $('.unit_measure_entity_error').html('');
            $('.unit_measure_name_error').html('');
        }
    });
</script>
