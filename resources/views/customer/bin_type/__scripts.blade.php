<script type="text/javascript">
    $(function() {
        let id = $('#pre_purchase_request_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#labelFilter,#lengthFilter,#widthFilter,#heightFilter,#binTypeIdFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#customerBinType').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('customer_bin_types.list') }}",
                data: function(d) {
                    d.id = id;
                    d.label_search = $('#labelFilter').val();
                    d.length_search = $('#lengthFilter').val();
                    d.width_search = $('#widthFilter').val();
                    d.height_search = $('#heightFilter').val();
                    d.bin_type_id_search = $('#binTypeIdFilter').val();
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
                }, // Row index column
                {
                    data: 'label',
                    name: 'label'
                },
                {
                    data: 'x',
                    name: 'x'
                },
                {
                    data: 'y',
                    name: 'y'
                },
                {
                    data: 'z',
                    name: 'z'
                },
                {
                    data: 'length',
                    name: 'length'
                },
                {
                    data: 'width',
                    name: 'width'
                },
                {
                    data: 'height',
                    name: 'height'
                },
                {
                    data: 'zone',
                    name: 'zone'
                },
                {
                    data: 'bin_type_id',
                    name: 'bin_type_id'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Bin Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#customerBinTypeModel',
                    'id': 'createBinType',
                },
                action: function(e, dt, node, config) {
                    $('#saveBinTypeData').html("Save Bin Type");
                    $('#customer_bin_type_id').val('');
                    $('#customerBinTypeModelForm').trigger("reset");
                    $('.label_error').html('');
                    $('#customerBinTypeModel #modelHeading').html("Create New Bin Type");
                    $('#customerBinTypeModel').modal('show');
                }
            }],
        });

        $('#saveBinTypeData').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#customer_bin_type_id').val() ? "{{ route('customer_bin_types.update', ':id') }}".replace(':id', $('#customer_bin_type_id').val()) : "{{ route('customer_bin_types.store') }}";
            var type = $('#customer_bin_type_id').val() ? "PUT" : "POST";
            var formData = $('#customerBinTypeModelForm').serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#customerBinTypeModelForm').trigger("reset");
                        $('#customerBinTypeModel').modal('hide');
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

        $('body').on('click', '.editBinTypebtn', function() {
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('customer_bin_types.index') }}" + '/' + id + '/edit', function(data) {
                $('#customerBinTypeModel #modelHeading').html("Edit Bin Type");
                $('#saveBinTypeData').val("edit-bin-type");
                $('#saveBinTypeData').html("Update Bin Type");
                $('#customerBinTypeModel').modal('show');
                $('#customer_bin_type_id').val(data.id);
                $('#label').val(data.label);
                $('#type').val(data.type);
                $('#x').val(data.x);
                $('#y').val(data.y);
                $('#z').val(data.z);
                $('#length').val(data.length);
                $('#width').val(data.width);
                $('#height').val(data.height);
                $('#bin_type_id').val(data.bin_type_id).trigger('change');
                $('#zone').val(data.zone);
                $('#notes').val(data.notes);
            });
        });

        function resetForm() {
            $(".label_error").html("");
        }

        $('body').on('click', '.deleteBinTypebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteBinType(id);
            });
        });

        function deleteBinType(id) {
            var url = "{{ route('customer_bin_types.destroy', ':id') }}".replace(':id', id);
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

        $('body').on('click', '.showBinTypebtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('customer_bin_types.index') }}" + '/' + id, function(data) {
                $('#showCustomerBinTypemodal').modal('show');
                $('#showCustomerBinTypeForm #label').val(data.label);
                $('#showCustomerBinTypeForm #type').val(data.type);
                $('#showCustomerBinTypeForm #x').val(data.x);
                $('#showCustomerBinTypeForm #y').val(data.y);
                $('#showCustomerBinTypeForm #z').val(data.z);
                $('#showCustomerBinTypeForm #length').val(data.length);
                $('#showCustomerBinTypeForm #width').val(data.width);
                $('#showCustomerBinTypeForm #height').val(data.height);
                $('#showCustomerBinTypeForm #bin_type_id').val(data.bin_type_id).trigger('change');
                $('#showCustomerBinTypeForm #zone').val(data.zone);
                $('#showCustomerBinTypeForm #notes').val(data.notes);
            });
        });

        $('#bin_type_id').select2({
            placeholder: 'Select Bin Type',
            dropdownParent: $('#bin_type_id').parent()
        });

    });
</script>
