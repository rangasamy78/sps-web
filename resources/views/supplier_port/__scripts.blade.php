<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#supplierPortNameFilter, #avgDaysFilter, #countryFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('supplier_ports.list') }}",
                data: function(d) {
                    d.supplier_port_name_search = $('#supplierPortNameFilter').val();
                    d.avg_days_search = $('#avgDaysFilter').val();
                    d.country_name_search = $('#countryFilter').val();
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
                    data: 'supplier_port_name',
                    name: 'supplier_port_name'
                },
                {
                    data: 'avg_days',
                    name: 'avg_days'
                },
                {
                    data: 'country_name',
                    name: 'country_name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Supplier Port</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#supplierPortModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Supplier Port");
                    resetForm()
                    $('#country_id').val('').trigger('change');
                    $('#supplierPortForm').trigger("reset");
                    $("#supplierPortForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Supplier Port");
                    $('#supplierPortModel').modal('show');
                }
            }],
        });

        $('#supplierPortForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#supplier_port_id').val() ? "{{ route('supplier_ports.update', ':id') }}".replace(':id', $('#supplier_port_id').val()) : "{{ route('supplier_ports.store') }}";
            var type = $('#supplier_port_id').val() ? "PUT" : "POST";
            var formData = $('#supplierPortForm').serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#supplierPortForm').trigger("reset");
                        $('#supplierPortModel').modal('hide');
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
            $('.supplier_port_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('supplier_ports.index') }}" + '/' + id + '/edit', function(data) {
                resetForm()
                $('#modelHeading').html("Edit Supplier Port");
                $('#savedata').val("edit-supplier-type");
                $('#savedata').html("Update Supplier Port");
                $('#supplierPortModel').modal('show');
                $('#supplier_port_id').val(data.id);
                $('#supplier_port_name').val(data.supplier_port_name);
                $('#avg_days').val(data.avg_days);
                $('#country_id').val(data.country_id).trigger('change');
            });
        });
        
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSupplierPort(id);
            });
        });

        function deleteSupplierPort(id) {
            var url = "{{ route('supplier_ports.destroy', ':id') }}".replace(':id', id);
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

        function resetForm() {
            $('.supplier_port_name_error').html('');
            $('.avg_days_error').html('');
            $('.country_id_error').html('');
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('supplier_ports.index') }}" + '/' + id, function(data) {
                $('#showSupplierPortModal').modal('show');
                $('#showSupplierPortForm #supplier_port_name').val(data.model.supplier_port_name);
                $('#showSupplierPortForm #avg_days').val(data.model.avg_days);
                $('#showSupplierPortForm #country_id').val(data.model.country_id);
            });
        });
    });
</script>