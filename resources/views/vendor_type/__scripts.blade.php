<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#vendorTypeFilter').on('keyup change', function(e) {
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
                url: "{{ route('vendor_types.list') }}",
                data: function(d) {
                    d.vendor_type_search = $('#vendorTypeFilter').val();
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
                    data: 'vendor_type_name',
                    name: 'vendor_type_name'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Vendor Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#vendorTypeModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {

                    $('#savedata').html("Save Vendor Type");
                    $('#vendor_type_id').val('');
                    $('#vendorTypeForm').trigger("reset");
                    $('.vendor_type_name_error').html('');
                    $('#modelHeading').html("Create New Vendor Type");
                    $('#vendorTypeModel').modal('show');
                }
            }],
        });

        $('#vendorTypeForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#vendor_type_id').val() ? "{{ route('vendor_types.update', ':id') }}".replace(':id', $('#vendor_type_id').val()) : "{{ route('vendor_types.store') }}";
            var type = $('#vendor_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#vendorTypeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#vendorTypeForm').trigger("reset");
                        $('#vendorTypeModel').modal('hide');
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
            $.get("{{ route('vendor_types.index') }}" + '/' + id + '/edit', function(data) {
                $(".vendor_type_name_error").html("");
                $('#modelHeading').html("Edit Vendor Type");
                $('#savedata').val("edit-event-type");
                $('#savedata').html("Update Vendor Type");
                $('#vendorTypeModel').modal('show');
                $('#vendor_type_id').val(data.id);
                $('#vendor_type_name').val(data.vendor_type_name);
            });
        });
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteVendorType(id);
            });
        });

        function deleteVendorType(id) {
            var url = "{{ route('vendor_types.destroy', ':id') }}".replace(':id', id);

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
            $.get("{{ route('vendor_types.index') }}" + '/' + id, function(data) {
                $('#showVendorTypeModal').modal('show');
                $('#showVendorTypeForm #vendor_type_name').val(data.vendor_type_name);
            });
        });
    });
</script>
